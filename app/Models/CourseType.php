<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    /**
     * Table name in the database (this is optional)
     */
    protected $table = "course_types";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status'
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
     * Relation between course types and courses
     */
    public function courses()
    {
        return $this->hasMany('App\Models\Course', 'course_type_id', 'id');
    }
}
