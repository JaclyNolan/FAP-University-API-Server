<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'Students';
    protected $primaryKey = 'student_id';

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

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function classEnrollments()
    {
        return $this->hasMany(ClassEnrollment::class);
    }
}
