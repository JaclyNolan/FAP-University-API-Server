<?php

namespace App\Models;

use App\Events\ClassEnrollmentCreated;
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

    protected static function booted()
    {
        static::created(function($classEnrollment){
            event(new ClassEnrollmentCreated($classEnrollment));
        });
    }

    public function classCourse()
    {
        return $this->belongsTo(ClassCourse::class, 'class_course_id', 'class_course_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'class_enrollment_id');
    }

    public function attendance()
    {
        return $this->hasOne(Attendance::class, 'class_enrollment_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'class_enrollment_id');
    }
}
