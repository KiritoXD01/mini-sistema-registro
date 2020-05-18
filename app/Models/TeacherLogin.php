<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherLogin extends Model
{
    /**
     * Table name in the database (this is optional)
     */
    protected $table = "teacher_logins";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relation between the login timestamp and a user
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Teacher', 'teacher_id', 'id');
    }
}
