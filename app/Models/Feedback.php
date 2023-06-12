<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'class_enrollment_id',
        'feedback_content',
        'created_at',
    ];

    public function classEnrollment()
    {
        return $this->belongsTo(ClassEnrollment::class);
    }
}
