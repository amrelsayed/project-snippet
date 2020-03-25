<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'name', 'image', 'icon', 'category_id',
    ];

    protected $guarded = array();

    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }

    public function Products()
    {
        return $this->hasMany('App\Product');
    }
}
