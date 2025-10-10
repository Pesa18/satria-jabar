<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TeamSatria;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamSatriaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TeamSatria');
    }

    public function view(AuthUser $authUser, TeamSatria $teamSatria): bool
    {
        return $authUser->can('View:TeamSatria');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TeamSatria');
    }

    public function update(AuthUser $authUser, TeamSatria $teamSatria): bool
    {
        return $authUser->can('Update:TeamSatria');
    }

    public function delete(AuthUser $authUser, TeamSatria $teamSatria): bool
    {
        return $authUser->can('Delete:TeamSatria');
    }

    public function restore(AuthUser $authUser, TeamSatria $teamSatria): bool
    {
        return $authUser->can('Restore:TeamSatria');
    }

    public function forceDelete(AuthUser $authUser, TeamSatria $teamSatria): bool
    {
        return $authUser->can('ForceDelete:TeamSatria');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TeamSatria');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TeamSatria');
    }

    public function replicate(AuthUser $authUser, TeamSatria $teamSatria): bool
    {
        return $authUser->can('Replicate:TeamSatria');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TeamSatria');
    }

}