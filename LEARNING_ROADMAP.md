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
