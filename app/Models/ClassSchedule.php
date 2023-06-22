<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $table = 'Class_schedules';
    protected $primaryKey = 'class_schedule_id';

    protected $fillable = [
        'class_course_id',
        'day',
        'slot',
        'room',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function classCourse()
    {
        return $this->belongsTo(ClassCourse::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
