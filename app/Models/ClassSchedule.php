<?php

namespace App\Models;

use App\Events\ClassScheduleCreated;
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

    protected static function booted() {
        static::created(function($classSchedule) {
            event(new ClassScheduleCreated($classSchedule));
        });
    }

    public function classCourse()
    {
        return $this->belongsTo(ClassCourse::class, 'class_course_id', 'class_course_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_schedule_id');
    }
}
