<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $fillable = [
    	'name', 'phone', 'email', 'city_id', 'address', 'activity', 'notification_token'
    ];
}
