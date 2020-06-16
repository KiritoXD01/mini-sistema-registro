<?php

namespace App\Models;

use App\Enums\CourseModality;
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
        'teacher_id', 'study_subject_id', 'close_points',
        'hour_count', 'course_type_id', 'course_modality_id',
        'country_id'
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
     * Appends custom attributes
     */
    protected $appends = [
        'course_modality'
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

    /**
     * Relation between course types and courses
     */
    public function courseType()
    {
        return $this->belongsTo('App\Models\CourseType', 'course_type_id', 'id');
    }

    /**
     * Get the course modality
     */
    public function getCourseModalityAttribute()
    {
        return CourseModality::getItem($this->course_modality_id);
    }

    /**
     * Get the relation between the country and the course
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    /**
     * Get the relation between the city and the course
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id')->withDefault([
            'id' => 0,
            'name' => 'Undefined'
        ]);
    }
}
