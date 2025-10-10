<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\StatusLayanan;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusLayananPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StatusLayanan');
    }

    public function view(AuthUser $authUser, StatusLayanan $statusLayanan): bool
    {
        return $authUser->can('View:StatusLayanan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StatusLayanan');
    }

    public function update(AuthUser $authUser, StatusLayanan $statusLayanan): bool
    {
        return $authUser->can('Update:StatusLayanan');
    }

    public function delete(AuthUser $authUser, StatusLayanan $statusLayanan): bool
    {
        return $authUser->can('Delete:StatusLayanan');
    }

    public function restore(AuthUser $authUser, StatusLayanan $statusLayanan): bool
    {
        return $authUser->can('Restore:StatusLayanan');
    }

    public function forceDelete(AuthUser $authUser, StatusLayanan $statusLayanan): bool
    {
        return $authUser->can('ForceDelete:StatusLayanan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StatusLayanan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StatusLayanan');
    }

    public function replicate(AuthUser $authUser, StatusLayanan $statusLayanan): bool
    {
        return $authUser->can('Replicate:StatusLayanan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StatusLayanan');
    }

}