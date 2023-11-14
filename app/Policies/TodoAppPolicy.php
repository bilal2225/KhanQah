<?php

namespace App\Policies;

use App\Models\TodoApp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoAppPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Todoapp $todoApp)
    {
        return $user->id === $todoApp->user_id;
    }

    public function create(User $user)
    {
        return true; // Allow all authenticated users to create
    }

    public function update(User $user, Todoapp $todoApp)
    {
        return $user->id === $todoApp->user_id;
    }

    public function delete(User $user, Todoapp $todoApp)
    {
        return $user->id === $todoApp->user_id;
    }
}
