<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * Table name in the database (this is optional)
     */
    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime'
    ];

    /**
     * Gets the user that created the current user, if created_by is
     * null, it was created by SYSTEM
     */
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id')->withDefault([
            'name' => 'SYSTEM'
        ]);
    }

    /**
     * Gets all the times that the user logged in to the system
     */
    public function userLogins()
    {
        return $this->hasMany('App\Models\UserLogin', 'user_id', 'id');
    }
}
