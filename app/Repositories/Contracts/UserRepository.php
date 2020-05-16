<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepository
{
    public function create(array $attributes);
    public function update(array $attributes, User $user);
    public function destroy(User $user);
}
