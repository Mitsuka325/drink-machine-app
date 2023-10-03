<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{

    // 一覧ページ
    public function index(Request $request)
    {
        $query = Product::query();

        // メーカー名で絞り込み
        if ($request->company_id) {
            $query->where('company_id', $request->company_id);
        }

        // 商品名で検索
        if ($request->product_name) {
            $query->where('product_name', 'like', '%' . $request->product_name . '%');
        }

        $products = $query->paginate(2);
        return view('products.index', compact('products'));
    }

    // 作成ページ
    public function create()
    {
        return view('products.create');
    }

    // 作成機能
    public function store(Request $request)
    {
        DB::beginTransaction();//トランザクションを開始
        try {

        $product = new Product();
        $product->product_name = $request->input('product_name');
        $product->company_id = $request->input('company_id');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');

        //  商品画像の保存
        // フォームから送信されたリクエストの中に
        //  'img_path' というファイルが存在するか確認し、
        // 存在する場合にそのファイルを 'images' ディレクトリに保存し、
        // その保存されたファイルのパスを Product モデルの img_path に格納
        if ($request->hasFile('img_path')) {
            $imgPath = $request->file('img_path')->store('images');
            $product->img_path = $imgPath;
        }
            $product->save();//データベースへの保存
            DB::commit();//トランザクションをコミット
            return redirect()->route('products.index')->with('flash_message', '商品の登録が完了しました');
            // リダイレクトフラッシュメッセージの表示 layouts/app.bladeにsessionの設定をする
        } catch (\Throwable $th) {
            DB::rollBack();//エラーがあった場合はロールバック
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
    public function update(Request $request, Product $product)
    {
        DB::beginTransaction();
        try {
        $product->product_name = $request->input('product_name');
        $product->company_id = $request->input('company_id');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');

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