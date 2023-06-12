<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = [
        'class_course_id',
        'day',
        'slot',
        'room',
        'status',
        'created_at',
        'updated_at',
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
