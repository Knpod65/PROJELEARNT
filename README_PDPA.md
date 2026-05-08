# PDPA-Aware Internal Data Management System

A comprehensive Laravel-based system designed to manage personal data in compliance with the Personal Data Protection Act (PDPA). This application demonstrates SOLID principles, modern Laravel architecture, and privacy-by-design concepts.

## Quick Start

### Access the Application
- URL: http://127.0.0.1:8000
- Test Users (use any of these):
  - Email: admin@pdpa.local | Password: password | Role: Admin
  - Email: staff@pdpa.local | Password: password | Role: Staff  
  - Email: viewer@pdpa.local | Password: password | Role: Viewer

### Database Status
- Database: pdpa_internal_app
- Host: 127.0.0.1:3306
- User: root (no password)
- All migrations: ✓ Complete
- Seeders: ✓ Test users created

## System Features

### 1. Data Subject Records Management
- Full CRUD operations with role-based access
- Track personal information with consent status
- Monitor data categories and retention periods
- Automatic audit logging of all changes

### 2. PDPA Rights Requests Workflow
- Support for all 6 PDPA rights:
  - Right to Access
  - Right to Be Forgotten (deletion)
  - Right to Rectification
  - Data Portability
  - Right to Restrict Processing
  - Right to Object
- Status tracking: pending → in_progress → completed
- 30-day deadline management
- Assignment to staff members

### 3. Comprehensive Audit Logging
- Every action is logged with:
  - User identification
  - Action type
  - Modified records
  - Changes (before/after)
  - IP address and user agent
- Compliant with PDPA audit trail requirements

### 4. Role-Based Access Control
- **Admin**: Full system access, user management capability
- **Staff**: Can view and manage records and requests
- **Viewer**: Read-only access to non-sensitive data
- Authorization checks on all operations

### 5. Dashboard Analytics
- System statistics overview
- Request status breakdown
- Overdue request alerts
- Recent activity feed

## Database Architecture

### 4 Main Tables

**Users**
- Stores staff with roles (admin, staff, viewer)
- Active status flag for access control

**Data Subject Records**
- Personal data of individuals
- Consent status tracking
- Data category classification
- Retention period tracking

**Data Subject Requests**
- Tracks PDPA rights requests
- Request type and status
- Deadline and completion tracking
- Assignment and response management

**Audit Logs**
- Morphic table for tracking changes
- Captures full audit trail
- Security event logging

## Development Files Structure

```
app/
├── Models/
│   ├── User.php                    # User with roles
│   ├── DataSubjectRecord.php       # Subject records
│   ├── DataSubjectRequest.php      # PDPA requests
│   └── AuditLog.php                # Audit trail
├── Http/Controllers/
│   ├── DashboardController.php     # Statistics
│   ├── DataSubjectRecordController.php
│   └── DataSubjectRequestController.php
└── Policies/ (ready for implementation)

database/
├── migrations/                     # Database schema
├── factories/                      # Test data factories
└── seeders/                        # Test user seeding

config/
└── pdpa.php                        # Configuration options

routes/
└── web.php                         # Application routes
```

## Key Implementation Details

### SOLID Principles Applied
1. **Single Responsibility**: Models handle data, Controllers handle routing
2. **Open/Closed**: Config-driven options enable extension
3. **Liskov Substitution**: Controllers follow consistent interfaces
4. **Interface Segregation**: Focused, single-purpose methods
5. **Dependency Inversion**: Type-hinted dependencies

### Design Patterns Used
1. **MVC Pattern**: Models, Controllers, Views separation
2. **Factory Pattern**: Model factories for testing
3. **Middleware Pattern**: Auth and RBAC via middleware
4. **Service Pattern**: Ready for service layer (to be enhanced)
5. **Repository Pattern**: Query scopes in models
6. **Observer Pattern**: Audit logging hooks (to be enhanced)

### DRY Principle Implementation
1. Configuration-driven option lists (config/pdpa.php)
2. Model scopes for common queries
3. Named routes for all URL generation
4. Reusable view components (planned)
5. Shared partial templates (planned)

## API Routes (Currently Implemented)

```
GET  /dashboard                    Dashboard
GET  /records                      List data subjects
POST /records                      Create record
GET  /records/{id}                 View record
PUT  /records/{id}                 Update record
DELETE /records/{id}               Delete record

GET  /requests                     List requests
POST /requests                     Create request
GET  /requests/{id}                View request
PUT  /requests/{id}                Update request
DELETE /requests/{id}              Delete request

Auth routes via Breeze:
POST /login, /register, /logout, /forgot-password
```

## Configuration (config/pdpa.php)

Centralized configuration for:
- Available roles and their labels
- Data categories (personal, financial, health, employment, other)
- Consent status options (given, withdrawn, pending)
- Lawful basis for processing
- PDPA request types
- Default request deadline (30 days)
- Default retention period (365 days)

## Model Relationships

```
User
  ├── hasMany → DataSubjectRecord (created_by)
  ├── hasMany → DataSubjectRequest (created_by)
  └── hasMany → AuditLog

DataSubjectRecord
  ├── belongsTo → User (created_by)
  ├── hasMany → DataSubjectRequest
  └── morphMany → AuditLog

DataSubjectRequest
  ├── belongsTo → DataSubjectRecord
  ├── belongsTo → User (created_by)
  ├── belongsTo → User (assigned_to)
  └── morphMany → AuditLog
```

## View Hierarchy (To Be Created)

```
layouts/
├── app.blade.php              # Main layout
├── guest.blade.php            # Login layout
└── components/
    ├── navbar.blade.php
    ├── sidebar.blade.php
    └── cards/

dashboard/
└── index.blade.php

records/
├── index.blade.php
├── create.blade.php
├── edit.blade.php
└── show.blade.php

requests/
├── index.blade.php
├── create.blade.php
├── edit.blade.php
└── show.blade.php
```

## Next Development Phases

### Phase 1: Core Views (Not Yet Implemented)
- Create comprehensive Blade templates
- Implement data tables with sorting/filtering
- Add form validation feedback
- Create responsive design

### Phase 2: Advanced Features (Planned)
- Authorization policies (Laravel Policies)
- Service layer for business logic
- Form request validation classes
- Advanced search functionality
- Export features (CSV, PDF)

### Phase 3: Compliance & Security (Planned)
- Email notifications
- Data masking for viewers
- Advanced audit report generation
- Compliance documentation
- API rate limiting

### Phase 4: Testing (Planned)
- Unit tests
- Feature tests
- API tests
- Performance tests

## Environment Setup Notes

### What's Already Done
✓ Laravel 13.8 installed
✓ MySQL configured and running
✓ Database migrations completed
✓ Test users seeded
✓ Authentication (Breeze) installed
✓ PDPA configuration created
✓ Models with relationships implemented
✓ Controllers with CRUD logic implemented
✓ Routes configured
✓ Audit logging infrastructure ready

### What's Next
- Create view templates for all features
- Implement authorization policies
- Add form validation
- Create responsive UI
- Write comprehensive tests
- Generate documentation

## Key Model Methods Available

```php
// User
$user->dataSubjectRecords()
$user->isAdmin()
$user->isStaff()

// DataSubjectRecord  
$record->createdBy()
$record->requests()
$record->scopeActive()
$record->scopeByCategory()

// DataSubjectRequest
$request->dataSubjectRecord()
$request->scopePending()
$request->scopeOverdue()
$request->isOverdue()

// AuditLog
AuditLog::log($action, $user, $type, $id, $changes)
```

## Performance Considerations

- Eager loading implemented in controllers (with())
- Pagination set to 15 items per page
- Indexed columns in database (email, ic_number, consent_status, etc.)
- Scopes for efficient queries

## Security Implementation

✓ Password hashing (Bcrypt)
✓ CSRF protection (Laravel)
✓ SQL injection prevention (Eloquent)
✓ Role-based authorization
✓ Audit trail logging
✓ IP address tracking
✓ User agent logging

## Command Reference

```bash
# Start development server
php artisan serve

# Run migrations
php artisan migrate

# Seed test data
php artisan db:seed

# Create new model/controller
php artisan make:model Name -mfs
php artisan make:controller NameController

# View routes
php artisan route:list

# Clear cache
php artisan cache:clear
php artisan config:clear
```

## Current Status

**Completed:**
- Database schema and migrations
- 4 core models with relationships
- 3 controllers with CRUD logic
- Authentication system
- Test user seeding
- Configuration system
- Audit logging infrastructure

**In Progress:**
- View templates
- Authorization policies
- Form validation

**Not Yet Started:**
- Advanced search
- Reporting features
- Email notifications
- API documentation
- Comprehensive tests

## Support Resources

- Laravel Docs: https://laravel.com/docs
- PDPA Information: https://www.pdpc.gov.sg/
- Blade Templates: https://laravel.com/docs/blade
- Eloquent ORM: https://laravel.com/docs/eloquent

## Development Tips

1. **Hot Reload**: Run `php artisan serve` for automatic reloading
2. **Tinker**: Use `php artisan tinker` for database exploration
3. **Query Log**: Enable query logging to optimize database calls
4. **Dump & Die**: Use `dd($variable)` for debugging
5. **Artisan Commands**: Explore with `php artisan list`

---

**Built with Laravel 13.8 | MySQL 8.4.8 | PHP 8.4.21**
