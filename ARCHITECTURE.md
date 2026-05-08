# Architecture & Design Patterns Documentation

## System Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                        │
│                   (Blade Templates)                          │
│  Views: Dashboard | Records | Requests | Audit Logs         │
└────────────────────────┬────────────────────────────────────┘
                         │
┌────────────────────────▼────────────────────────────────────┐
│                   ROUTING LAYER                              │
│              (routes/web.php + routes/auth.php)             │
│  Middleware: auth, verified, role-based checks             │
└────────────────────────┬────────────────────────────────────┘
                         │
┌────────────────────────▼────────────────────────────────────┐
│                   CONTROLLER LAYER                           │
│        (Thin Controllers - Input Validation & Response)      │
│  DashboardController, DataSubjectRecordController, etc.     │
└────────────────────────┬────────────────────────────────────┘
                         │
┌────────────────────────▼────────────────────────────────────┐
│                   BUSINESS LOGIC LAYER                       │
│      (Models + Scopes + Relationships - Ready for Service)  │
│  User, DataSubjectRecord, DataSubjectRequest, AuditLog     │
└────────────────────────┬────────────────────────────────────┘
                         │
┌────────────────────────▼────────────────────────────────────┐
│                   DATA ACCESS LAYER                          │
│              (Eloquent ORM + Query Builder)                 │
│    Migrations, Factories, Seeders, Database Operations      │
└────────────────────────┬────────────────────────────────────┘
                         │
┌────────────────────────▼────────────────────────────────────┐
│                   DATABASE LAYER                             │
│               (MySQL 8.4.8 - pdpa_internal_app)            │
│  Tables: users, data_subject_records, requests, audit_logs │
└─────────────────────────────────────────────────────────────┘
```

## SOLID Principles Implementation

### 1. Single Responsibility Principle (SRP)

**Controllers** - Handle HTTP requests and responses only
```php
class DataSubjectRecordController extends Controller
{
    // Responsible only for:
    // - Receiving HTTP requests
    // - Validating input
    // - Calling model methods
    // - Returning responses
    
    public function store(Request $request)
    {
        $validated = $request->validate([...]);
        $record = DataSubjectRecord::create($validated);
        return redirect()->route('records.show', $record);
    }
}
```

**Models** - Encapsulate data and business logic
```php
class DataSubjectRecord extends Model
{
    // Responsible for:
    // - Data representation
    // - Relationships
    // - Query scopes
    // - Domain logic methods
    
    public function scopeActive($query)
    {
        return $query->where('consent_status', '!=', 'withdrawn');
    }
}
```

**Audit Logging** - Single responsibility for logging
```php
class AuditLog extends Model
{
    // Responsible only for audit trail
    public static function log($action, $user, $type, $id, $changes)
    {
        return self::create([
            'user_id' => $user->id,
            'action' => $action,
            // ...
        ]);
    }
}
```

### 2. Open/Closed Principle (OCP)

**Configuration-Driven Options** - Easy to extend without modifying code
```php
// config/pdpa.php
return [
    'roles' => ['admin', 'staff', 'viewer'],
    'data_categories' => ['personal', 'financial', 'health', ...],
    'lawful_basis' => ['consent', 'contract', 'legal_obligation', ...],
];

// Usage in code - never hardcoded
$roles = config('pdpa.roles');
$categories = config('pdpa.data_categories');
```

**Open for Extension** - Add new roles/categories without changing code
```php
// Just update config/pdpa.php
'roles' => ['admin', 'staff', 'viewer', 'auditor'], // New role added
```

### 3. Liskov Substitution Principle (LSP)

**Consistent Controller Interface**
```php
// All resource controllers follow same interface
class DataSubjectRecordController extends Controller
{
    public function index()       // List all
    public function create()      // Create form
    public function store()       // Save new
    public function show()        // View one
    public function edit()        // Edit form
    public function update()      // Save changes
    public function destroy()     // Delete
}

// Can be substituted for DataSubjectRequestController
// with identical interface - Liskov satisfied
```

**Model Scopes** - Consistent query patterns
```php
// All models use similar scope patterns
DataSubjectRecord::active()->get();
DataSubjectRequest::pending()->get();
// Both return consistent, chainable query builders
```

### 4. Interface Segregation Principle (ISP)

**Focused Model Methods**
```php
// User model - segregated into specific concerns
class User extends Model
{
    // Relationship methods
    public function dataSubjectRecords() { ... }
    
    // Role checking methods
    public function isAdmin() { ... }
    public function isStaff() { ... }
    
    // Authentication methods (inherited from Authenticatable)
}

// Not a bloated god object - each interface segregated
```

### 5. Dependency Inversion Principle (DIP)

**Type-Hinted Dependencies in Controllers**
```php
class DataSubjectRecordController extends Controller
{
    // Depends on abstractions (interfaces), not concretions
    public function store(Request $request)
    {
        // Request is type-hinted - DI container injects it
        $validated = $request->validate([...]);
    }
    
    public function show(DataSubjectRecord $record)
    {
        // Model binding - Laravel resolves it
        // Controller doesn't create the instance
    }
}
```

## Design Patterns Implementation

### 1. Model-View-Controller (MVC) Pattern

**Separation of Concerns:**
- **Model**: `app/Models/*` - Data and business logic
- **View**: `resources/views/*` - Template rendering
- **Controller**: `app/Http/Controllers/*` - Request handling

### 2. Service Pattern (Ready for Implementation)

**Future Enhancement** - Extract business logic into services
```php
// App\Services\DataSubjectService
class DataSubjectService
{
    public function createRecord(array $data, User $user)
    {
        $record = DataSubjectRecord::create($data);
        AuditLog::log('created', $user, 'DataSubjectRecord', $record->id);
        return $record;
    }
}

// Controller delegates to service
class DataSubjectRecordController
{
    public function __construct(DataSubjectService $service)
    {
        $this->service = $service;
    }
    
    public function store(Request $request)
    {
        return $this->service->createRecord(
            $request->validated(),
            auth()->user()
        );
    }
}
```

### 3. Factory Pattern

**Model Factories for Testing**
```php
// database/factories/DataSubjectRecordFactory.php
class DataSubjectRecordFactory extends Factory
{
    protected $model = DataSubjectRecord::class;
    
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'ic_number' => fake()->unique()->numerify('######-##-####'),
        ];
    }
}

// Usage
$record = DataSubjectRecord::factory()->create();
$records = DataSubjectRecord::factory(10)->create();
```

### 4. Middleware Pattern

**Authentication & Role-Based Access Control**
```php
// In routes/web.php
Route::middleware('auth')->group(function () {
    Route::resource('records', DataSubjectRecordController::class);
});

// Middleware handles:
// - Authentication verification
// - Session management
// - CSRF token validation
```

### 5. Observer Pattern (Ready for Implementation)

**Model Observers for Audit Logging**
```php
// Future: App\Observers\DataSubjectRecordObserver
class DataSubjectRecordObserver
{
    public function creating(DataSubjectRecord $record)
    {
        // Auto-set created_by
        $record->created_by = auth()->id();
    }
    
    public function updating(DataSubjectRecord $record)
    {
        // Log before update
        AuditLog::log('updating', auth()->user(), ...);
    }
}

// Register in AppServiceProvider
DataSubjectRecord::observe(DataSubjectRecordObserver::class);
```

### 6. Morphic Relationship Pattern

**Flexible Audit Logging**
```php
// AuditLog can relate to ANY model (Polymorphic)
class AuditLog extends Model
{
    public function model()
    {
        return $this->morphTo();
    }
}

// Usage
$audit->model();  // Returns the associated model (Record/Request/etc)
$record->auditLogs();  // Gets all audits for that record
```

## DRY (Don't Repeat Yourself) Implementation

### 1. Configuration-Driven Options

**Single Source of Truth**: `config/pdpa.php`
```php
// Instead of hardcoding in multiple places:
// ❌ if ($role === 'admin') ...
// ❌ if ($role === 'staff') ...
// ✅ if (in_array($role, config('pdpa.roles'))) ...
```

### 2. Model Query Scopes

**Reusable Query Patterns**
```php
// Instead of repeating WHERE clauses:
// ❌ $records = DB::table('records')->where('consent_status', '!=', 'withdrawn');
// ✅ $records = DataSubjectRecord::active();

class DataSubjectRecord extends Model
{
    public function scopeActive($query)
    {
        return $query->where('consent_status', '!=', 'withdrawn');
    }
    
    public function scopeByCategory($query, $category)
    {
        return $query->where('data_category', $category);
    }
}

// Chain and reuse
$records = DataSubjectRecord::active()->byCategory('health')->get();
```

### 3. Relationships (No Redundant Queries)

**Instead of repeated joins:**
```php
// ❌ SELECT * FROM records
//    SELECT * FROM users WHERE id = ?  (for each record)
// ✅ Eager loading
$records = DataSubjectRecord::with('createdBy', 'requests')->get();
```

### 4. Named Routes (Consistent URL Generation)

**Instead of hardcoded paths:**
```php
// ❌ href="/records/{{ $record->id }}/edit"
// ✅ route('records.edit', $record)

// routes/web.php
Route::resource('records', DataSubjectRecordController::class);

// In views
{{ route('records.show', $record) }}
{{ route('records.edit', $record) }}
```

### 5. Shared Validation Rules (Planned)

**Future Form Requests**
```php
// App\Http\Requests\StoreDataSubjectRecordRequest
class StoreDataSubjectRecordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:data_subject_records',
            // ...
        ];
    }
}

// Reused in controller
public function store(StoreDataSubjectRecordRequest $request)
{
    // Already validated by FormRequest
    DataSubjectRecord::create($request->validated());
}
```

## Database Design Principles

### Normalization

**3NF Compliance**
- No repeating groups
- Atomic values only
- All non-key columns depend on primary key

### Indexing Strategy

```
users:
  - PRIMARY KEY: id
  - UNIQUE: email

data_subject_records:
  - PRIMARY KEY: id
  - UNIQUE: email, ic_number
  - INDEX: consent_status (filtering)

data_subject_requests:
  - PRIMARY KEY: id
  - INDEX: request_type, status
  - INDEX: deadline_date (overdue queries)

audit_logs:
  - PRIMARY KEY: id
  - INDEX: user_id (user activity)
  - INDEX: created_at (recent activity)
  - INDEX: model_type, model_id (tracking changes)
```

### Relationships

**One-to-Many**
```
User → DataSubjectRecord (one user creates many records)
User → DataSubjectRequest (one user creates many requests)
User → AuditLog (one user performs many actions)

DataSubjectRecord → DataSubjectRequest (one subject has many requests)
```

**Polymorphic**
```
AuditLog →◆ (can log any model type)
```

## Validation & Authorization Flow

### Request Validation
```
HTTP Request
    ↓
Controller → Request::validate()
    ↓
If invalid → Back with errors
If valid → Proceed to authorization
    ↓
Authorization check ($this->authorize())
    ↓
If unauthorized → 403 Forbidden
If authorized → Execute business logic
    ↓
Model update/create/delete
    ↓
AuditLog::log() - Record the action
    ↓
Response (redirect or JSON)
```

## Security Architecture

### Layers

1. **Routing Layer**: Middleware authentication
2. **Authorization Layer**: Policy-based access control
3. **Data Layer**: Encryption for sensitive fields (future)
4. **Audit Layer**: Complete logging trail

### Threats Mitigated

| Threat | Mitigation |
|--------|-----------|
| SQL Injection | Eloquent ORM parameterized queries |
| XSS | Blade template escaping {{ }} |
| CSRF | Laravel CSRF token verification |
| Unauthorized Access | Middleware + Authorization checks |
| Sensitive Data Exposure | Audit logging + Role-based masking |
| Audit Trail Tampering | Immutable logs (not yet deleted) |

## Performance Optimization

### Query Optimization
- Eager loading with `with()`
- Query scopes for efficiency
- Database indexes on filtered columns
- Pagination (15 items per page)

### Caching Opportunities (Future)
```php
// Configuration - cached automatically
config('pdpa.roles')

// Database queries - for static data
cache()->rememberForever('pdpa_roles', fn() => ...);

// View fragments
@cache('statistics', 3600)
    {{ $stats }}
@endcache
```

## Testing Architecture (To Be Implemented)

### Test Structure
```
tests/
├── Unit/
│   ├── Models/
│   │   ├── UserTest.php
│   │   ├── DataSubjectRecordTest.php
│   │   └── DataSubjectRequestTest.php
│   └── Services/
├── Feature/
│   ├── Controllers/
│   │   ├── DashboardControllerTest.php
│   │   ├── DataSubjectRecordControllerTest.php
│   │   └── DataSubjectRequestControllerTest.php
│   └── Workflows/
└── Browser/
```

### Example Test Pattern
```php
class DataSubjectRecordTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_create_record()
    {
        $user = User::factory()->create(['role' => 'staff']);
        
        $response = $this->actingAs($user)
            ->post('/records', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                // ...
            ]);
        
        $this->assertDatabaseHas('data_subject_records', [
            'email' => 'john@example.com'
        ]);
    }
}
```

## Deployment Considerations

### Environment Configuration
```
.env (local development)
.env.staging (staging environment)
.env.production (production)
```

### Key Configuration Items
- Database credentials
- App debug mode (false in production)
- Log level and channels
- Cache driver
- Session driver
- Queue driver (for email notifications)

## Future Enhancements

### Phase 2: Advanced Features
1. Service layer for complex business logic
2. Form request classes for validation
3. Authorization policies for fine-grained control
4. Advanced search with filters
5. Export to CSV/PDF

### Phase 3: Compliance
1. Email notifications
2. Data masking for viewers
3. Compliance reporting
4. Advanced audit reports
5. Data retention policies

### Phase 4: Testing
1. Comprehensive unit tests
2. Feature tests
3. Integration tests
4. Performance tests

---

**This architecture ensures maintainability, scalability, and compliance with data protection principles.**
