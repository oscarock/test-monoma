<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Aspirant;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function viewAny(User $user)
    {
        // Usuarios con rol "manager" pueden obtener todos los candidatos
        return $user->role === 'manager';
    }

    public function create(User $user)
    {
        // Solo los usuarios con rol "manager" pueden crear candidatos
        return $user->role === 'manager';
    }
}
