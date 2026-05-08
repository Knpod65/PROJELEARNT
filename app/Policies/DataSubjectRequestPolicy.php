<?php

namespace App\Policies;

use App\Models\DataSubjectRequest;
use App\Models\User;

class DataSubjectRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['admin', 'staff', 'viewer']);
    }

    public function view(User $user, DataSubjectRequest $request): bool
    {
        if (!$user->is_active) return false;
        return in_array($user->role, ['admin', 'staff', 'viewer']);
    }

    public function create(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['admin', 'staff']);
    }

    public function update(User $user, DataSubjectRequest $request): bool
    {
        return $user->is_active && in_array($user->role, ['admin', 'staff']);
    }

    public function approve(User $user, DataSubjectRequest $request): bool
    {
        return $user->is_active && $user->role === 'admin';
    }

    public function delete(User $user, DataSubjectRequest $request): bool
    {
        return $user->is_active && $user->role === 'admin';
    }
}
