<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    /**
     * Table name in the database (this is optional)
     */
    protected $table = "course_students";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'course_id', 'assigned_by'
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
     * Gets the user that created the current user, if created_by is
     * null, it was created by SYSTEM
     */
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'assigned_by', 'id')->withDefault([
            'name' => 'SYSTEM'
        ]);
    }

    /**
     * Gets the student that is assigned to the course
     */
    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'id');
    }

    /**
     * Gets the course that is assigned to the student
     */
    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id', 'id');
    }
}
