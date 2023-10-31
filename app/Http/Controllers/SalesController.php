<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    public function purchaseProduct(Request $request)
    {
        $productId = $request->input('product_id');

        // Check if product exists
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => '商品が見つかりません'], 404);
        }

        // Check if product is in stock
        if ($product->stock <= 0) {
            return response()->json(['error' => '在庫が不足しています'], 400);
        }

        DB::beginTransaction();

        try {
            // Decrease product stock
            $product->stock--;
            $product->save();

            // Add purchase record (assuming a column 'product_id' exists in sales table)
            Sale::create(['product_id' => $productId]);

            DB::commit();
            return response()->json(['message' => '購入が完了しました'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => '購入処理に失敗しました'], 500);
        }
    }
}