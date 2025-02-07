<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    public function isAdmin(User $user)
    {
        return $user->role === 'admin';
    }

    public function isSuperAdmin(User $user)
    {
        return $user->role === 'superadmin';
    }
    public function isStudent(User $user)
    {
        return $user->role === 'student';
    }
    public function isFaculty(User $user)
    {
        return $user->role === 'faculty';
    }
    public function isAlumini(User $user)
    {
        return $user->role === 'Alumuni';
    }

}
