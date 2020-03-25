<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = ['user_id', 'product_id', 'review', 'title', 'comment'];

    const STATUS_ENUM = [
        'PENDING' => 0,
        'ACTIVE' => 1,
        'REJECTED' => 2
    ];

    public function user()
    {
    	return $this->belongsTo(Buyer::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Product::class, 'product_id');
    }
}
