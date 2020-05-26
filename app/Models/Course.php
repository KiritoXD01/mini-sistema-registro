<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * Table name in the database (this is optional)
     */
    protected $table = "courses";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'status', 'created_by',
        'teacher_id', 'study_subject_id'
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
        return $this->belongsTo('App\Models\User', 'created_by', 'id')->withDefault([
            'name' => 'SYSTEM'
        ]);
    }

    /**
     * Gets the teacher that is assigned to this course
     */
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'teacher_id', 'id');
    }

    /**
     * Gets the teacher that is assigned to this course
     */
    public function studySubject()
    {
        return $this->belongsTo('App\Models\StudySubject', 'study_subject_id', 'id');
    }

    /**
     * Get all the students enrolled to this course
     */
    public function students()
    {
        return $this->hasMany('App\Models\CourseStudent', 'course_id', 'id');
    }
}
