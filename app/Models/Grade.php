<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'Grades';
    protected $primaryKey = 'grade_id';

    protected $fillable = [
        'class_enrollment_id',
        'score',
        'status',
        'created_at',
        'updated_at',
    ];

    public function findStatus($score)
    {
        if ($score == null) return "None";
        if ($score < 60) return "Failed";
        if ($score < 80) return "Passed";
        if ($score < 90) return "Merit";
        return "Distiction";
    }

    protected static function booted()
    {
        static::creating(function($grade) {
            $grade->status = $grade->findStatus($grade->score);
        });
        static::updating(function($grade) {
            if ($grade->isDirty('score'))
            $grade->status = $grade->findStatus($grade->score);
        });
    }

    public function classEnrollment()
    {
        return $this->belongsTo(ClassEnrollment::class, 'class_enrollment_id', 'class_enrollment_id');
    }
}
