<?php

namespace App\Providers;

use App\Models\DataSubjectRecord;
use App\Models\DataSubjectRequest;
use App\Policies\DataSubjectRecordPolicy;
use App\Policies\DataSubjectRequestPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        DataSubjectRecord::class => DataSubjectRecordPolicy::class,
        DataSubjectRequest::class => DataSubjectRequestPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
