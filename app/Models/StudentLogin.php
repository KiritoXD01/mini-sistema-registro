<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentLogin extends Model
{
    /**
     * Table name in the database (this is optional)
     */
    protected $table = "student_logins";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id'
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
     * Relation between the login timestamp and a teacher
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'id');
    }
}
