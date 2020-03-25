<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Model;

class SellerHistory extends Model
{
    protected $table = 'seller_history';

    protected $fillable = ['seller_id', 'admin_id', 'content'];

    public function admin()
    {
    	return $this->belongsTo(\App\User::class, 'admin_id');
    }
}
