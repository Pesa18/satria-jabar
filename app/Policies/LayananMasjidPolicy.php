<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\LayananMasjid;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayananMasjidPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LayananMasjid');
    }

    public function view(AuthUser $authUser, LayananMasjid $layananMasjid): bool
    {
        return $authUser->can('View:LayananMasjid');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LayananMasjid');
    }

    public function update(AuthUser $authUser, LayananMasjid $layananMasjid): bool
    {
        return $authUser->can('Update:LayananMasjid');
    }

    public function delete(AuthUser $authUser, LayananMasjid $layananMasjid): bool
    {
        return $authUser->can('Delete:LayananMasjid');
    }

    public function restore(AuthUser $authUser, LayananMasjid $layananMasjid): bool
    {
        return $authUser->can('Restore:LayananMasjid');
    }

    public function forceDelete(AuthUser $authUser, LayananMasjid $layananMasjid): bool
    {
        return $authUser->can('ForceDelete:LayananMasjid');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LayananMasjid');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LayananMasjid');
    }

    public function replicate(AuthUser $authUser, LayananMasjid $layananMasjid): bool
    {
        return $authUser->can('Replicate:LayananMasjid');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LayananMasjid');
    }

}