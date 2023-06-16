<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'Attendances';
    protected $primaryKey = 'attendance_id';

    protected $fillable = [
        'class_schedule_id',
        'class_enrollment_id',
        'attendance_status',
        'attendance_time',
        'updated_at',
    ];

    public function classSchedule()
    {
        return $this->belongsTo(ClassSchedule::class);
    }

    public function classEnrollment()
    {
        return $this->belongsTo(ClassEnrollment::class);
    }
}