<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'staff_id',
        'full_name',
        'phone_number',
        'gender',
        'date_of_birth',
        'address',
        'image',
        'department',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
