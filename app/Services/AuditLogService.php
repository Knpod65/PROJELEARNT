<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLogService
{
    public static function logCreated(Model $model, string $description = null): AuditLog
    {
        $description = $description ?? "Created {$model->getTable()} record";

        return AuditLog::log(
            'created',
            Auth::user(),
            $model::class,
            $model->id,
            null,
            $description
        );
    }

    public static function logUpdated(Model $model, array $oldValues = null, array $newValues = null, string $description = null): AuditLog
    {
        $changes = null;
        if ($oldValues && $newValues) {
            $changes = ['old' => $oldValues, 'new' => $newValues];
        }

        $description = $description ?? "Updated {$model->getTable()} record";

        return AuditLog::log(
            'updated',
            Auth::user(),
            $model::class,
            $model->id,
            $changes,
            $description
        );
    }

    public static function logDeleted(Model $model, string $description = null): AuditLog
    {
        $description = $description ?? "Deleted {$model->getTable()} record";

        return AuditLog::log(
            'deleted',
            Auth::user(),
            $model::class,
            $model->id,
            null,
            $description
        );
    }

    public static function logAction(string $action, Model $model, string $description = null, array $changes = null): AuditLog
    {
        $description = $description ?? "Performed {$action} on {$model->getTable()} record";

        return AuditLog::log(
            $action,
            Auth::user(),
            $model::class,
            $model->id,
            $changes,
            $description
        );
    }
}
