<?php

namespace App;

use App\Notifications\SellerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'about',
        'city_id', 
        'address', 
        'shipping',
        'image', 
        'status', 
        'email', 
        'password', 
        'new_name', 
        'new_about',
        'new_city_id', 
        'new_address', 
        'new_shipping', 
        'new_email', 
        'edit_status', 
        'notes', 
        'subscribtion_id',
        'username',
    ];

    const STATUS_ENUM = [
        'ACTIVE' => 1,
        'BLOCKED' => 2
    ];

    const SUBSCRIBTIONS_ENUM = [
        'FREE' => 1,
        'PAYED_1' => 2,
        'PAYED_2' => 3,
        'PAYED_3' => 4,
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SellerResetPassword($token));
    }
    
    public function product($id){
        $count = \App\Product::where('seller_id',$id)->where('status',1)->count();
        return $count;
    }

    public function city()
    {
        return $this->belongsTo('App\City','city_id');
    }

    public function new_city()
    {
        return $this->belongsTo('App\City','new_city_id');
    }

    public function campaign($id){
        $count = \App\Campaign::where('seller_id',$id)->where('status',1)->count();
        return $count;
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function pendingProducts()
    {
        return $this->hasMany(Product::class)
           ->where('status', 0);
    }

    public function approvedProducts()
    {
        return $this->hasMany(Product::class)
           ->where('status', 1);
    }

    public function canceledProducts()
    {
        return $this->hasMany(Product::class)
           ->where('status', 2);
    }

    public function deletedProducts()
    {
        return $this->hasMany(Product::class)->onlyTrashed();
    }

    public function featuredProducts()
    {
        return $this->hasMany(Product::class)
           ->where('featured', 10);
    }

    public function sellerShipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping', 'id');
    }

    public function subscribtion()
    {
        return $this->belongsTo(Subscribtion::class);
    }

    public function history()
    {
        return $this->hasMany(\App\Models\Seller\SellerHistory::class);
    }
}
