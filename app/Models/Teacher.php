<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    /**
     * Table name in the database (this is optional)
     */
    protected $table = "teachers";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
        'code', 'status', 'created_by'
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
     * Encrypts the incoming password
     * @param $value = the incoming password
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Gets all the times that the user logged in to the system
     */
    public function teacherLogins()
    {
        return $this->hasMany('App\Models\TeacherLogin', 'teacher_id', 'id');
    }

    /**
     * Returns the teacher's full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /*
     * Get the courses assigned to the teacher
     */
    public function courses()
    {
        return $this->hasMany('App\Models\Course', 'teacher_id', 'id');
    }
}
