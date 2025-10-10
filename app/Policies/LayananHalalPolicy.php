<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\LayananHalal;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayananHalalPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LayananHalal');
    }

    public function view(AuthUser $authUser, LayananHalal $layananHalal): bool
    {
        return $authUser->can('View:LayananHalal');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LayananHalal');
    }

    public function update(AuthUser $authUser, LayananHalal $layananHalal): bool
    {
        return $authUser->can('Update:LayananHalal');
    }

    public function delete(AuthUser $authUser, LayananHalal $layananHalal): bool
    {
        return $authUser->can('Delete:LayananHalal');
    }

    public function restore(AuthUser $authUser, LayananHalal $layananHalal): bool
    {
        return $authUser->can('Restore:LayananHalal');
    }

    public function forceDelete(AuthUser $authUser, LayananHalal $layananHalal): bool
    {
        return $authUser->can('ForceDelete:LayananHalal');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LayananHalal');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LayananHalal');
    }

    public function replicate(AuthUser $authUser, LayananHalal $layananHalal): bool
    {
        return $authUser->can('Replicate:LayananHalal');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LayananHalal');
    }

}