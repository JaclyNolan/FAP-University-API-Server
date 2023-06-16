<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassEnrollment extends Model
{
    protected $table = 'Class_enrollments';
    protected $primaryKey = 'class_enrollment_id';

    protected $fillable = [
        'class_course_id',
        'student_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function classCourse()
    {
        return $this->belongsTo(ClassCourse::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
