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

    public $SLOT_TIMES = [
        [
            'slot' => 1,
            'start_time' => '7:15:00',
            'end_time' => '9:15:00',
        ],
        [
            'slot' => 2,
            'start_time' => '9:20:00',
            'end_time' => '11:20:00',
        ],
        [
            'slot' => 3,
            'start_time' => '12:10:00',
            'end_time' => '14:10:00',
        ],
        [
            'slot' => 4,
            'start_time' => '14:15:00',
            'end_time' => '16:15:00',
        ],
        [
            'slot' => 5,
            'start_time' => '16:20:00',
            'end_time' => '18:20:00',
        ],
        [
            'slot' => 6,
            'start_time' => '18:25:00',
            'end_time' => '20:25:00',
        ],
    ];

    protected static function booted()
    {
        static::created(function ($classSchedule) {
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
