<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'Courses';
    protected $primaryKey = 'course_id';

    protected $fillable = [
        'major_id',
        'course_name',
        'credits',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id', 'major_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }

    public function classCourses()
    {
        return $this->hasMany(ClassCourse::class, 'course_id');
    }
}
