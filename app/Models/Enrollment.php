<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'Enrollments';
    protected $primaryKey = 'enrollment_id';

    protected $fillable = [
        'student_id',
        'course_id',
        'status',
        'status_name',
        'created_at',
        'updated_at',
    ];

    public function findStatus($number)
    {
        switch ($number) {
            case 1:
                return "Not Register";
            case 2:
                return "In Progress";
            case 3:
                return "Reserved";
            case 4:
                return "Failed";
            default:
                return "Passed";
        };
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}
