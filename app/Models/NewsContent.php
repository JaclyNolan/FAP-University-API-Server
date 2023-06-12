<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsContent extends Model
{
    protected $fillable = [
        'title',
        'content',
        'author',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
