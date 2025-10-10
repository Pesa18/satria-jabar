<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\LayananKiblat;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayananKiblatPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LayananKiblat');
    }

    public function view(AuthUser $authUser, LayananKiblat $layananKiblat): bool
    {
        return $authUser->can('View:LayananKiblat');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LayananKiblat');
    }

    public function update(AuthUser $authUser, LayananKiblat $layananKiblat): bool
    {
        return $authUser->can('Update:LayananKiblat');
    }

    public function delete(AuthUser $authUser, LayananKiblat $layananKiblat): bool
    {
        return $authUser->can('Delete:LayananKiblat');
    }

    public function restore(AuthUser $authUser, LayananKiblat $layananKiblat): bool
    {
        return $authUser->can('Restore:LayananKiblat');
    }

    public function forceDelete(AuthUser $authUser, LayananKiblat $layananKiblat): bool
    {
        return $authUser->can('ForceDelete:LayananKiblat');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LayananKiblat');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LayananKiblat');
    }

    public function replicate(AuthUser $authUser, LayananKiblat $layananKiblat): bool
    {
        return $authUser->can('Replicate:LayananKiblat');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LayananKiblat');
    }

}