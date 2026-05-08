<?php

namespace App\Providers;

use App\Models\AuditLog;
use App\Models\DataSubjectRecord;
use App\Models\DataSubjectRequest;
use App\Policies\AuditLogPolicy;
use App\Policies\DataSubjectRecordPolicy;
use App\Policies\DataSubjectRequestPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(AuditLog::class, AuditLogPolicy::class);
        Gate::policy(DataSubjectRecord::class, DataSubjectRecordPolicy::class);
        Gate::policy(DataSubjectRequest::class, DataSubjectRequestPolicy::class);
    }
}
