<?php
namespace App\Policies;

use App\Models\Package;
use App\Models\User;

class PackagePolicy
{
    public function update(User $user, Package $package): bool
    {
        return $user->hasRole('admin');
    }
}