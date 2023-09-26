@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>新規商品登録完了</h2>

                <div class="alert alert-success" role="alert">
                    商品の登録が完了しました。
                </div>

            </div>
            <strong>商品名:</strong>{{ $product->product_name }}<br>
            <strong>メーカー名:</strong>{{ $product->company_id }}<br>
            <strong>価格:</strong>{{ $product->price }}<br>
            <strong>在庫数:</strong>{{ $product->stock }}<br>
            <strong>コメント:</strong>{{ $product->comment }}<br>
            <strong>商品画像:</strong><img src="{{ asset($product->img_path) }}"alt="商品画像">
        </div>
        <a href="{{ route('products.index') }}"class="btn btn-secondary mt-3">戻る</a>
    </div>
    </div>
    </div>
@endsection
