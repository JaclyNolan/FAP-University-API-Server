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

    public function classEnrollment()
    {
        return $this->belongsTo(ClassEnrollment::class);
    }
}
