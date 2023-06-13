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

    protected $table = 'users';
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
        'deleted_at',
    ];

    public function getAccordingIdFromRole() {
        switch ($this->role_id) {
            case 1: //Admin
                return null;
            case 2: //Staff
                return $this->staff_id;
            case 3: //Instructor
                return $this->instructor_id;
            case 4: //Student
                return $this->student_id;
        }
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
        return $this->belongsTo(Role::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
