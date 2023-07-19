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

    private $STATUS_NAME = [
        [
            'status' => 1,
            'name' => "Not Register"
        ],
        [
            'status' => 2,
            'name' => "Waiting For Payment"
        ],
        [
            'status' => 3,
            'name' => "Paid"
        ],
        [
            'status' => 4,
            'name' => "In Progress"
        ],
        [
            'status' => 5,
            'name' => "Reserved"
        ],
        [
            'status' => 6,
            'name' => "Failed"
        ],
        [
            'status' => 7,
            'name' => "Passed"
        ],
    ];

    public function getStatusName()
    {
        return $this->STATUS_NAME;
    }

    public function findStatus($number)
    {
        foreach ($this->STATUS_NAME as $status) {
            if ($status['status'] == $number) return $status['name'];
        }
        return "Error";
    }

    protected static function booted()
    {
        static::creating(function ($enrollment) {
            $enrollment->status_name = $enrollment->findStatus($enrollment->status);
        });
        static::updating(function ($enrollment) {
            if ($enrollment->isDirty('status'))
                $enrollment->status_name = $enrollment->findStatus($enrollment->status);
        });
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
