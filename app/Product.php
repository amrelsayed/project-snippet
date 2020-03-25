<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Request;

class Product extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'brand', 'raws', 'origin', 'name',  'product_description',  'unit_id',  'seller_unit_id',  'price', 'lowest', 'lowest_price', 'selling_description', 'shipping',  'sample',  'image',  'sample_price',  'notes', 'status', 'refuse_msg', 'category_id', 'sub_id',  'seller_id',  'views',  'clicks', 'pay', 'discount', 'published_at', 'featured'
    ];

    const STATUS_ENUM = [
        'PENDING' => 0,
        'ACTIVE' => 1,
        'REFUSED' => 2
    ];

    protected $guarded = array();

    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }
    
    public function sub()
    {
        return $this->belongsTo('App\SubCategory','sub_id');
    }
    
    public function unit()
    {
        return $this->belongsTo('App\Unit','unit_id');
    }
    
    public function seller_unit()
    {
        return $this->belongsTo('App\SellerUnit','seller_unit_id');
    }
    
    public function origins()
    {
        return $this->belongsTo('App\Origin','origin');
    }

    public function seller()
    {
        return $this->belongsTo('App\Seller','seller_id');
    }
    
    public function campaign($id){
        $campaigns = \App\Campaign::where('product_id',$id)->orderBy('id')->get();

        return $campaigns;
    }

    public function image($id){
        
        $image = \App\ProductImage::where('product_id',$id)->first();

        return $image;
    }

    public function images() 
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\User\ProductReview::class, 'product_id');
    }

    public function user_review()
    {
        return $this->hasOne(\App\Models\User\ProductReview::class, 'product_id');
    }
}
