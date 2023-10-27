<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment'
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    public function scopeCompanyId(Builder $query, $company_id): Builder
    {
        return $query->where('company_id', $company_id);
    }
    public function scopeProductName(Builder $query, $product_name): Builder
    {
        return $query->where('product_name', 'like', '%' . $product_name . '%');
    }

    public function scopeSearch($query, $request)
    {
        $product_name = $request->product_name;
        $company_id = $request->company_id;
        $price_value = $request->price_range;
        $stock_value = $request->stock_range;
        return
            // 検索キーワード入力時
            $query->when($request->product_name ?? false, function ($query, $product_name) {
                $query->where('product_name', 'like', '%' . $product_name . '%');
            })
            // メーカー入力時
            ->when($request->company_id ?? false, function ($query, $company_id) {
                $query->where('company_id', $company_id);
            })
            // 価格入力時
            ->when($request->price_range ?? false, function ($query, $price_value) {
                $query->whereBetween(
                    'price',
                    [
                        explode('-', $price_value)[0],
                        explode('-', $price_value)[1]
                    ]
                );
            })

            // 在庫入力時
            ->when($request->stock_range ?? false, function ($query, $stock_value) {
                $query->whereBetween(
                    'stock',
                    [
                        explode('-', $stock_value)[0],
                        explode('-', $stock_value)[1]
                    ]
                );
            });
    }
}
