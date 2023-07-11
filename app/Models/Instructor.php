<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $table = 'Instructors';
    protected $primaryKey = 'instructor_id';
    protected $keyType = 'string';

    protected $fillable = [
        'instructor_id',
        'major_id',
        'full_name',
        'date_of_birth',
        'phone_number',
        'gender',
        'address',
        'image',
        'position',
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

    public function classCourses()
    {
        return $this->hasMany(ClassCourse::class);
    }
}
