<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
