<?php

namespace App\Repositories\Eloquent;


use App\Models\User;
use App\Repositories\Contracts\UserRepository;

class EloquentUserRepository implements UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(array $attributes)
    {
        $attributes['created_by'] = auth()->user()->id;
        return $this->user->create($attributes);
    }

    public function update(array $attributes, User $user)
    {
        return $user->update($attributes);
    }

    public function destroy(User $user)
    {
        return $user->delete();
    }
}
