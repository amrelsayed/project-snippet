<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'image', 'product_id', 'live_id',
    ];

    protected $guarded = array();
    
    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function live()
    {
        return $this->belongsTo('App\LiveProduct','live_id');
    }
}
