<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribtion extends Model
{
    public $timestamps = false;

    protected $fillable = ['id', 'name', 'featured_products'];
}
