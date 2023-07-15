<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'Users';

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'role_id',
        'student_id',
        'staff_id',
        'instructor_id',
        'username',
        'password',
        'email',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getAccordingIdFromRole() {
        switch ($this->getRoleName()) {
            case "Admin": //Admin
                return null;
            case "Staff": //Staff
                return $this->staff_id;
            case "Instructor": //Instructor
                return $this->instructor_id;
            case "Student": //Student
                return $this->student_id;
        }
    }

    public function getInfoAccordingToRole() {
        switch ($this->role_id) {
            case 1:
                return null;
            case 2:
                return $this->staff;
            case 3:
                return $this->instructor;
            case 4:
                return $this->student;
        }
    }

    public function getRoleName() {
        return $this->role->role_name;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id', 'instructor_id');
    }
}
