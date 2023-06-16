<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ClassCourse extends Model
{
    protected $table = 'Class_courses';
    protected $primaryKey = 'class_course_id';

    protected $fillable = [
        'class_id',
        'course_id',
        'instructor_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function classEnrollments()
    {
        return $this->hasMany(ClassEnrollment::class);
    }
}
