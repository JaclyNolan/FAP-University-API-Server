<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'Majors';
    protected $primaryKey = 'major_id';

    protected $fillable = [
        'major_name',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function instructors()
    {
        return $this->hasMany(Instructor::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassModel::class);
    }
}
