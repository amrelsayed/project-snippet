<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'keywords', 'body', 'image'];

    public function getImageAttribute($value)
    {
    	return asset('posts/' . $value);
    }

    public function getCreatedAtAttribute($value)
    {
    	return date('Y-m-d', strtotime($value));
    }
}
