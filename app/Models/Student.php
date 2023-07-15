<?php

namespace App\Models;

use App\Events\StudentCreated;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'Students';
    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'major_id',
        'full_name',
        'date_of_birth',
        'phone_number',
        'gender',
        'address',
        'image',
        'academic_year',
        'gpa',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function booted()
    {
        static::created(function($student) {
            event(new StudentCreated($student));
        });
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id', 'major_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'student_id', 'student_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function classEnrollments()
    {
        return $this->hasMany(ClassEnrollment::class, 'student_id', 'student_id');
    }

}
