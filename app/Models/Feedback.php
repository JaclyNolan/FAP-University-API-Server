<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'Feedbacks';
    protected $primaryKey = 'feedback_id';

    public $timestamps = false;
    protected $fillable = [
        'class_enrollment_id',
        'feedback_content',
        'created_at',
    ];

    public function classEnrollment()
    {
        return $this->belongsTo(ClassEnrollment::class, 'class_enrollment_id', 'class_enrollment_id');
    }
}
