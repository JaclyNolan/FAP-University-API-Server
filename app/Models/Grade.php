<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
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
