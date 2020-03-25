<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'ip', 'product_id', 'click',
    ];

    protected $guarded = array();

    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function click()
    {
        return $this->belongsTo('App\Product','click');
    }
}
