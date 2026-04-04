<?php

namespace App\Policies;

use App\Models\Password;
use App\Models\User;

class PasswordPolicy
{
    /**
     * Determina se o usuário pode ver a senha.
     * Apenas o dono da senha pode visualizá-la.
     */
    public function view(User $user, Password $password): bool
    {
        return $user->id === $password->user_id;
    }

    /**
     * Determina se o usuário pode editar a senha.
     */
    public function update(User $user, Password $password): bool
    {
        return $user->id === $password->user_id;
    }

    /**
     * Determina se o usuário pode deletar a senha.
     */
    public function delete(User $user, Password $password): bool
    {
        return $user->id === $password->user_id;
    }
}
