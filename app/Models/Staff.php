<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'Staffs';
    protected $primaryKey = 'staff_id';
    public $incrementing = false;
    protected $keyType = 'string';


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
        return $this->hasOne(User::class);
    }
}
