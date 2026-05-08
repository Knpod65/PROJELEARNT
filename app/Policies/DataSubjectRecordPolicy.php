<?php

namespace App\Policies;

use App\Models\DataSubjectRecord;
use App\Models\User;

class DataSubjectRecordPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['admin', 'staff', 'viewer']);
    }

    public function view(User $user, DataSubjectRecord $record): bool
    {
        if (!$user->is_active) return false;
        return in_array($user->role, ['admin', 'staff', 'viewer']);
    }

    public function create(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['admin', 'staff']);
    }

    public function update(User $user, DataSubjectRecord $record): bool
    {
        return $user->is_active && in_array($user->role, ['admin', 'staff']);
    }

    public function delete(User $user, DataSubjectRecord $record): bool
    {
        return $user->is_active && $user->role === 'admin';
    }
}
