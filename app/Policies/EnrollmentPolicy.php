<?php
namespace App\Policies;

use App\Models\Enrollment;
use App\Models\User;

class EnrollmentPolicy
{
    public function cancel(User $user, Enrollment $enrollment): bool
    {
        return $user->id === $enrollment->user_id;
    }
}