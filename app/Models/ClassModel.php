<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'Class';
    protected $primaryKey = 'class_id';

    protected $fillable = [
        'major_id',
        'class_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id', 'major_id');
    }

    public function classCourses()
    {
        return $this->hasMany(ClassCourse::class, 'class_id');
    }
}
