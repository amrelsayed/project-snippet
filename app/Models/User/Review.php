<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['seller_id', 'rating', 'comment', 'phone'];
}
