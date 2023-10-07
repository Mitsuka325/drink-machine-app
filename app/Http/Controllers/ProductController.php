<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{

    //一覧ページ
    public function index(Request $request)
    {

        if ($request->company_id) {
            $products = Product::companyId($request->company_id)
                ->productName($request->product_name)
                ->paginate(2);
        } elseif ($request->product_name) {
            $products = product::productName($request->product_name)->paginate(2);
        } else {
            $products = product::paginate(2);
        }
        return view('products.index', compact('products'));
    }
    // 作成ページ
    public function create()
    {
        return view('products.create');
    }

    // 作成機能
    public function store(ProductRequest $request)
    {
        DB::beginTransaction(); //トランザクションを開始
        try {
            $validatedData = $request->validated(); // バリデーション済みデータ取得

            $product = new Product();
            $product->fill($validatedData);

            if ($request->hasFile('img_path')) {
                $imgPath = $request->file('img_path')->store('images');
                $product->img_path = $imgPath;
            }
            $product->save(); //データベースへの保存

            DB::commit(); //トランザクションをコミット
            return redirect()->route('products.index')->with('flash_message', '商品の登録が完了しました');
            // リダイレクトフラッシュメッセージの表示 layouts/app.bladeにsessionの設定をする
        } catch (\Throwable $th) {
            DB::rollBack(); //エラーがあった場合はロールバック
            return back()->withErrors(['error' => '商品の作成に失敗しました']);
        }
    }
    // 詳細ページ 
    // compact関数で変数をビューに渡す
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // 更新ページ
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }


    // 更新処理
    public function update(ProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated(); // バリデーション済みデータ取得
            $product->fill($validatedData);

            if ($request->hasFile('img_path')) {
                $imgPath = $request->file('img_path')->store('images');
                $product->img_path = $imgPath;
            }
            $product->save();
            DB::commit();
            return redirect()->route('products.index')->with('flash_message', '商品の更新が完了しました');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error' => '商品の更新に失敗しました']);
        }
    }

    // 削除機能
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
            return redirect()->route('products.index')->with('flash_message', '商品を削除しました');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error' => '商品の削除に失敗しました']);
        }
    }
}
