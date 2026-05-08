# 7-Day Laravel Learning Roadmap

This roadmap uses the PDPA project in this repository to teach Laravel in a practical order. The goal is not just to run the app, but to understand how a professional Laravel codebase is organized and why the structure matters.

## Learning Goal

By the end of 7 days, you should be able to explain and work through this flow with confidence:

`Route -> Middleware -> Controller -> FormRequest -> Service -> Model -> Database -> View`

You will also cover:

- Laravel fundamentals
- MVC
- SOLID principles
- DRY
- Design patterns
- MySQL
- Authentication
- Authorization
- Blade views
- PDPA-aware design
- Audit logging
- Data masking

## How To Use This Roadmap

- Read the listed files in order.
- Run the suggested commands locally.
- Make one small code change each day.
- Write short notes in your own words after each session.

## Day 1: Laravel Fundamentals And Project Map

### Focus

Understand how Laravel organizes a project and where each responsibility lives.

### Read These Files

- `composer.json`
- `.env.example`
- `routes/web.php`
- `config/pdpa.php`
- `app/Models/User.php`

### Learn

- What Laravel is responsible for
- Why `.env` stays out of Git
- The difference between framework config and business config
- How the project is separated into app, routes, config, database, and views

### Commands

```bash
php artisan route:list
php artisan about
```

### Exercise

Trace the `/dashboard` route from `routes/web.php` to the controller that handles it. Write down which middleware protects it and what data the page needs.

### Outcome

You can explain the project layout without guessing.

## Day 2: MVC And The Full Request Lifecycle

### Focus

Understand MVC by tracing a real request in this project.

### Read These Files

- `routes/web.php`
- `app/Http/Controllers/DataSubjectRecordController.php`
- `app/Models/DataSubjectRecord.php`
- `resources/views/records/index.blade.php`
- `resources/views/records/show.blade.php`

### Learn

- How routing sends a request into a controller
- What a controller should do and not do
- How models represent database-backed business data
- How Blade views render the response
- How MVC maps to this PDPA project

### Exercise

Trace `GET /records` from route to controller to model query to Blade view. Then trace `GET /records/{record}` the same way.

### Outcome

You can explain MVC using actual files from this repository.

## Day 3: Validation, FormRequest, And DRY

### Focus

Learn how request validation should be structured and how DRY improves maintainability.

### Read These Files

- `app/Http/Requests/StoreDataSubjectRecordRequest.php`
- `app/Http/Requests/UpdateDataSubjectRecordRequest.php`
- `app/Http/Requests/StoreDataSubjectRequestRequest.php`
- `app/Http/Requests/UpdateDataSubjectRequestRequest.php`
- `app/Http/Controllers/DataSubjectRecordController.php`
- `app/Http/Controllers/DataSubjectRequestController.php`

### Learn

- Why validation belongs close to input handling
- The difference between inline validation and FormRequest classes
- How DRY reduces repeated validation logic
- How cleaner controllers improve readability

### Exercise

Compare the existing inline validation in the controllers with the FormRequest classes already present in `app/Http/Requests`. Note which actions could be refactored so the request flow becomes:

`Route -> Middleware -> Controller -> FormRequest -> Service -> Model -> Database -> View`

### Outcome

You understand why FormRequest classes are a Laravel best practice and where they fit in the lifecycle.

## Day 4: Services, SOLID, And Design Patterns

### Focus

Learn how reusable logic is extracted and how object-oriented design improves real projects.

### Read These Files

- `app/Services/AuditLogService.php`
- `app/Services/DataMaskingService.php`
- `app/Helpers/DataMasking.php`
- `config/pdpa.php`

### Learn

- Single Responsibility Principle through service classes
- DRY through shared logic
- Service Layer as a practical design pattern
- Policy-driven behavior through config values
- Why masking and audit logic should not be duplicated across controllers and views

### Exercise

Explain which responsibilities belong to:

- controller
- service
- model
- helper
- config

Then identify one place where a future refactor could reduce duplication further.

### Outcome

You can explain how SOLID and design patterns show up in normal Laravel code, not just in theory.

## Day 5: MySQL, Migrations, Eloquent, And Seeders

### Focus

Understand how the application schema supports PDPA features.

### Read These Files

- `database/migrations/2026_05_08_042305_create_data_subject_records_table.php`
- `database/migrations/2026_05_08_042306_create_data_subject_requests_table.php`
- `database/migrations/2026_05_08_042307_create_audit_logs_table.php`
- `database/migrations/2026_05_08_042331_add_role_to_users_table.php`
- `database/seeders/DatabaseSeeder.php`
- `database/seeders/UserSeeder.php`
- `app/Models/DataSubjectRecord.php`
- `app/Models/DataSubjectRequest.php`
- `app/Models/AuditLog.php`

### Learn

- How Laravel migrations map to MySQL tables
- How Eloquent models represent relationships and query logic
- Why seeders are useful for repeatable local setup
- How MySQL supports audit trails, deadlines, and retention fields

### Commands

```bash
php artisan migrate:status
php artisan migrate:fresh --seed
```

### Exercise

Open the record and request migrations and identify the fields that directly support PDPA-aware design, such as consent status, lawful basis, retention tracking, request deadlines, and audit history.

### Outcome

You can connect the MySQL schema to the business rules of the app.

## Day 6: Authentication, Authorization, And Middleware

### Focus

Learn how Laravel decides who can log in and what they are allowed to do.

### Read These Files

- `routes/web.php`
- `app/Models/User.php`
- `app/Policies/DataSubjectRecordPolicy.php`
- `app/Policies/DataSubjectRequestPolicy.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- `database/seeders/UserSeeder.php`

### Learn

- Authentication: proving who the user is
- Authorization: deciding what the user can do
- How middleware like `auth` and `verified` protects routes
- How roles such as `admin`, `staff`, and `viewer` affect system behavior
- Why authorization matters more in PDPA-sensitive apps

### Exercise

Compare what an `admin`, `staff`, and `viewer` should be allowed to do in the PDPA project. Then map those expectations to the policies and middleware already in the codebase.

### Outcome

You can clearly explain the difference between authentication, authorization, middleware, and policies.

## Day 7: Blade Views, PDPA-Aware Design, Audit Logging, And Masking

### Focus

Bring the full picture together and study what makes this project specifically PDPA-aware.

### Read These Files

- `resources/views/dashboard/index.blade.php`
- `resources/views/records/index.blade.php`
- `resources/views/records/show.blade.php`
- `resources/views/privacy-notice.blade.php`
- `app/Services/AuditLogService.php`
- `app/Services/DataMaskingService.php`
- `config/pdpa.php`

### Learn

- How Blade views present server-side data
- How sensitive fields should be displayed carefully
- Why viewer-facing masking is a privacy control
- How audit logging supports accountability
- How PDPA-aware design affects both backend logic and UI behavior

### Exercise

Pick one user action, such as creating or updating a record, and describe the full lifecycle in writing:

`Route -> Middleware -> Controller -> FormRequest -> Service -> Model -> Database -> View`

If the current implementation does not use every step yet, note the gap and describe how you would refactor it.

### Outcome

You finish the week able to explain the architecture, the privacy controls, and the next refactoring opportunities in this codebase.

## Suggested End-Of-Week Refactor List

- Move inline validation from controllers into the existing FormRequest classes
- Introduce clearer service boundaries for create and update workflows
- Add or improve feature tests for authorization and masking behavior
- Review Blade views for consistent privacy-safe field presentation
- Document the most important PDPA business rules beside the code that enforces them

## Final Success Check

At the end of the 7 days, you should be able to answer these questions without looking anything up:

- How does a request enter and move through this Laravel app?
- What is the difference between a controller, service, model, policy, and view?
- Where is validation supposed to happen and why?
- How do MySQL migrations and seeders support repeatable setup?
- How are authentication and authorization different?
- How does this project implement PDPA-aware design through audit logs and masking?

## Supplement: From Handwritten Architecture Notes to Laravel PDPA Project

This supplement connects your handwritten Laravel architecture notes to the real PDPA project in this repository. The goal is to help you think like an engineer who can look at rough diagrams such as `Route -> Middleware -> Controller -> Model -> View` and then find the real implementation in a working codebase.

Important current-project note:

- `app/Services/DataSubjectRecordService.php` does not exist yet.
- `app/Services/PrivacyMaskingService.php` does not exist yet.
- The current project uses `app/Services/AuditLogService.php` and `app/Services/DataMaskingService.php`.
- `DataSubjectRecordController` still contains business logic that would be a good candidate for future service extraction.

That means this supplement teaches you two things at once:

- how the current project works today
- how to recognize the next refactor direction for cleaner Laravel architecture

### 1. Laravel Request Lifecycle

Your handwritten flow is:

`Route -> Middleware -> AuthMiddleware -> Controller -> Model -> View`

For this project, the fuller Laravel learning version is:

`URL / Route -> Middleware -> Auth / Policy -> Controller -> FormRequest -> Service -> Model -> MySQL -> Blade View -> Audit Log`

Map that idea to this repository:

- `routes/web.php` receives the URL and chooses the controller action.
- Route middleware such as `auth` and `verified` protects pages before controller logic runs.
- Policy checks such as `can:viewAny,App\Models\AuditLog` and `$this->authorize(...)` decide who is allowed to proceed.
- Controllers such as `DashboardController` and `DataSubjectRecordController` coordinate the request.
- FormRequest classes already exist in `app/Http/Requests`, even though some controller actions still use inline validation today.
- A service layer is already partially present through `AuditLogService`, and a future `DataSubjectRecordService` would be a good next step.
- Eloquent models such as `DataSubjectRecord` and `AuditLog` talk to MySQL-backed tables.
- Blade files in `resources/views` render the final HTML response.
- When sensitive actions happen, `AuditLogService` records evidence in `audit_logs`.

If you trace `/records`, you can mentally read it like this:

1. `routes/web.php` maps the request to `DataSubjectRecordController`.
2. `auth` and `verified` middleware run first.
3. The controller calls authorization logic through `$this->authorize(...)`.
4. Validation happens in the controller today, but the project already contains FormRequest classes that show the preferred direction.
5. The model reads and writes database rows.
6. The Blade view shows the result.
7. If data changes, audit logging is triggered.

Laravel 13 note:

- In this project, route-level middleware is easier to read and safer for learning.
- Old constructor middleware like `$this->middleware('auth')` caused problems and should not be the default pattern here.
- Prefer route-level middleware in `routes/web.php`, or the supported Laravel controller middleware API when truly needed.

### 2. Middleware as Authentication, Authorization, and PDPA Control

Middleware is not just a technical filter. In a PDPA-aware app, middleware is part of privacy protection.

Think about it in three layers:

1. Authentication:
- Is the user logged in?
- Example: a guest visiting `/dashboard` is redirected to `/login`.

2. Authorization:
- Even if the user is logged in, are they allowed to do this action?
- Example: `/audit-logs` requires more than login. It uses policy-based access so not every user can see accountability data.

3. PDPA protection:
- Even if a user can open a page, should they see full personal data or masked data?
- Example: viewers can read operational pages, but sensitive fields should be masked and audit logs should stay restricted.

Use the current project examples:

- guest -> `/dashboard` -> redirect to login
- admin -> `/audit-logs` -> allowed
- viewer -> `/audit-logs` -> `403 Forbidden`

This teaches an important Laravel idea:

- middleware blocks access before controller logic
- policies refine access at the action or model level
- masking protects what the user can see even after access is granted

### 3. Controller Should Be Thin

“Thin Controller” means the controller should coordinate work, not contain all the work.

A controller should:

- receive the request
- call validation
- call service or model logic
- return a view or redirect

A controller should not:

- contain all business rules
- repeat validation rules everywhere
- write audit behavior in many unrelated places
- decide every PDPA visibility rule inside Blade
- become a giant class that knows everything

Use `DataSubjectRecordController` as the real example.

What it does well now:

- receives requests
- performs authorization
- returns views and redirects
- triggers audit logging through `AuditLogService`

What should become thinner later:

- move repeated validation into FormRequest classes
- move create and update business logic into a `DataSubjectRecordService`
- reduce direct controller responsibility for detailed data-handling workflows

The target learning shape is:

`Controller -> FormRequest -> DataSubjectRecordService -> Model -> AuditLogService`

That is the practical meaning of “Thin Controller” in Laravel.

### 4. Service Layer and SOLID

Why services exist:

- a `DataSubjectRecordService` would handle record business logic in one place
- `AuditLogService` already handles audit logging
- a privacy-focused masking service keeps masking rules out of every view
- controllers delegate work instead of carrying every rule themselves

Current project reality:

- `AuditLogService` exists and is already useful
- `DataMaskingService` exists and currently plays the masking role
- `DataSubjectRecordService` is a good next refactor target, not a finished file yet

Map this to SOLID:

SRP:
- `AuditLogService` should focus on audit logging
- `DataSubjectRecord` should focus on record data and relationships
- controllers should focus on request orchestration

OCP:
- `config/pdpa.php` stores statuses, roles, and categories
- this lets you extend options without hardcoding them all over the app

DIP:
- controllers should depend on service classes instead of scattered raw logic
- this project already shows the idea through `AuditLogService`, and can grow it further with a dedicated record service

This is the architecture lesson:

- clean Laravel code is not about creating many files for show
- it is about giving each class one clear reason to change

### 5. Model, Query Scope, and Data Access

The Model is your data access layer.

Typical Eloquent examples from the ideas in your notes:

- `DataSubjectRecord::where(...)`
- `DataSubjectRecord::pluck(...)`
- `DataSubjectRecord::all()`

These are the kinds of methods your handwritten notes were pointing toward with examples like:

- `model->get()`
- `model->where()`
- `model->pluck()`
- `model->all()`

In this project, reusable query logic is already pushed into scopes.

Examples:

- `DataSubjectRecord::active()`
- `DataSubjectRecord::retentionExpiringSoon()`
- `DataSubjectRequest::pending()`

Why scopes matter:

- they keep repeated conditions out of controllers
- they improve readability
- they support DRY

Repository-style thinking from your notes:

- `getBasicInfo()`
- `getAllInfo()`
- `StudentRepository::getBasicInfo()`

How to understand that in this project:

- right now, the project mainly uses Eloquent models plus scopes
- that is normal and acceptable for a small-to-medium Laravel app
- if data access becomes more complex, a Repository Pattern could be added later

So the honest learning summary is:

- current style: Eloquent + scopes + services where needed
- future extension: repositories for more complex data access rules

### 6. Basic Info vs Full Info vs Masked Info

PDPA is not only about storing data. It is also about deciding how much data each role should see.

Think in four information levels:

Basic Info:

- `record_code`
- `department`
- `status`

Full Info:

- `full_name`
- `email`
- `phone`

Masked Info:

- masked email
- masked phone

Governance Info:

- audit logs
- `old_values`
- `new_values`

Role visibility in this project should be understood like this:

admin:

- full operational access
- audit access
- highest accountability responsibility

staff:

- operational access needed to work with records and requests
- usually enough data to perform tasks
- not automatically entitled to full governance visibility

viewer:

- read-only access
- sensitive fields should be masked
- audit logs should not be visible

Why this matters:

- data minimization means users only see what they need
- purpose limitation means access should match the work purpose
- least privilege means fewer people should see full personal data
- privacy-by-design means these rules are built into the system, not added as an afterthought

### 7. Audit Log as PDPA Evidence

Audit logging is not just for debugging.

In a PDPA-aware system, logs are evidence.

An audit log should help answer:

1. Who did it?
2. What action happened?
3. Which record was affected?
4. What changed?
5. When did it happen?
6. From which IP or user agent?

Map that to this project:

- `audit_logs` table stores the evidence
- `AuditLog` model represents those rows
- `AuditLogService` creates log entries for sensitive actions

Examples of actions that matter:

- record created
- record updated
- record deleted
- data subject request created
- request approved or rejected
- sensitive record viewed
- unauthorized access attempt if you implement that later

Current project note:

- create, update, and delete actions are already logged in the record and request workflows
- view logging and unauthorized-attempt logging are still reasonable future improvements

Why audit trails matter for PDPA accountability:

- they help prove what happened
- they support internal investigation
- they support compliance review
- they create operational trust

### 8. Blade View Is Presentation Only

View means the presentation layer:

- HTML
- CSS
- JS

Good Blade behavior:

- display prepared data
- loop through records
- show badges and labels
- show buttons depending on authorization
- display validation errors

Bad Blade behavior:

- querying the database directly
- containing heavy business logic
- deciding all PDPA rules by itself
- writing logs
- performing large calculations

Use this project as the example:

- `resources/views/dashboard/index.blade.php` should display prepared counts, not build them from raw query logic
- `resources/views/records/index.blade.php` should render records and call simple display helpers such as masking functions

The key lesson is:

- controllers and services prepare data
- Blade presents data

### 9. Route Design

Your handwritten examples:

- `/profile/info`
- `/admin/student/manage`
- `/user/student`
- `collect/authen`

These are useful because they force you to ask: what is this URL trying to mean?

Laravel resource-route thinking is more structured:

- `Route::resource('records', DataSubjectRecordController::class);`
- `Route::resource('data-subject-requests', DataSubjectRequestController::class);`

A good route should answer:

- What resource is this?
- What HTTP method is being used?
- Which controller handles it?
- Which middleware protects it?
- What is the route name?
- Who can access it?

Examples from this project:

- `/dashboard` -> overview page
- `/records` -> record resource listing
- `/data-subject-requests` -> request resource listing
- `/audit-logs` -> governance/audit page with stricter access

This is the design lesson:

- routes should describe the system clearly
- routes should not be random strings
- routes should communicate both structure and intent

### 10. SOLID Mapping Table

| SOLID Principle | Meaning | Example in this project |
|---|---|---|
| SRP | One class should have one main responsibility. | `AuditLogService` focuses on audit behavior, while `AuditLog` focuses on audit data. |
| OCP | Extend behavior without rewriting everything. | `config/pdpa.php` lets you add statuses, roles, and labels without hardcoding values in many files. |
| LSP | Replacements should still behave correctly from the caller's point of view. | Not a strong formal example yet, but a future masking service contract should allow different masking implementations without breaking controllers or views. |
| ISP | Prefer smaller focused interfaces and responsibilities instead of giant ones. | The current codebase is closer to this idea when it keeps policies, models, services, and controllers separate instead of building one “god class.” |
| DIP | High-level code should depend on abstractions or focused collaborators, not scattered low-level details. | Controllers already delegate logging to `AuditLogService`, and a future `DataSubjectRecordService` would strengthen this further. |

### 11. Design Pattern Mapping Table

| Pattern | Where it appears | Why it matters |
|---|---|---|
| MVC Pattern | Routes, controllers, models, and Blade views work together across the whole app. | Gives the project a predictable structure for learning and maintenance. |
| Service Pattern | `AuditLogService` and `DataMaskingService`. | Keeps cross-cutting business logic out of controllers and views. |
| Middleware Pattern | `auth`, `verified`, and route protection in `routes/web.php`. | Stops unauthorized requests before controller logic runs. |
| Policy Pattern | Record, request, and audit access rules. | Separates permission logic from controllers and views. |
| Factory Pattern | `database/factories/*Factory.php`. | Supports testing and repeatable sample data creation. |
| Query Scope Pattern | `active()`, `retentionExpiringSoon()`, `pending()`. | Reuses common query rules and supports DRY. |
| Repository Pattern as future extension | Not a dedicated pattern in the current codebase yet. | Would help if data access grows more complex than normal Eloquent scopes and services can comfortably handle. |

### 12. Hands-On Exercises

Exercise A:

Trace one request from `/records` through:

- route
- middleware
- authorization
- controller
- model query
- view rendering
- masking behavior
- audit logging if a change happens

Exercise B:

Add a new field `source_channel` to `DataSubjectRecord`.

Work through:

- migration
- model `fillable`
- FormRequest validation or current controller validation
- Blade form
- index and show display
- factory or seeder updates
- test and build verification

Exercise C:

Add a new consent status in `config/pdpa.php` and make sure:

- forms use it
- dashboard counts reflect it
- labels stay consistent

Exercise D:

Login as `viewer` and verify:

- masked email is shown
- masked phone is shown
- audit logs stay forbidden

Exercise E:

Find where audit logs are created and explain:

- what `old_values` means
- what `new_values` means
- why both matter for accountability

### 13. Checkpoint Questions

You should be able to answer these after studying the supplement:

- What is the difference between route and controller?
- Why should middleware check login before controller?
- Why should controller not contain all logic?
- What is the difference between Model and Service?
- Why is a privacy masking service better than writing masking logic in every Blade file?
- Why should audit logs be admin-only?
- Why does PDPA require thinking about who can see what?
- Why is `config/pdpa.php` useful for DRY and OCP?
- What happens if `.env` is committed to GitHub?
