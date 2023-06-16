<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NewsContent extends Model
{
    protected $table = 'News_contents';
    protected $primaryKey = 'news_id';

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
