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

    private static $TIME_FOR_TAKE_ATTENDANCE = 15; //minutes

    private static $STATUS_NAME = [
        [
            'status' => 1,
            'name' => 'Not yet',
        ],
        [
            'status' => 2,
            'name' => 'Taking Attendance',
        ],
        [
            'status' => 3,
            'name' => 'In Progress',
        ],
        [
            'status' => 4,
            'name' => 'Ended',
        ],
    ];
    private static $SLOT_TIMES = [
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

    public static function getSlotTimes()
    {
        return ClassSchedule::$SLOT_TIMES;
    }

    public static function getTimeForTakeAttendance()
    {
        return ClassSchedule::$TIME_FOR_TAKE_ATTENDANCE;
    }

    public static function findSlotTime($slot)
    {
        foreach (ClassSchedule::getSlotTimes() as $slotTime)
            if ($slotTime['slot'] == $slot) return $slotTime;
    }

    public function isOpen() {
        return $this->status == 2;
    }

    public function isClose() {
        return $this->status == 3;
    }

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
