@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-md-10 text-end">

                <!-- 検索フォーム --Flexboxを使ってコンテンツを縦方向に並べる-->

                <form action="{{ route('products.index') }}"method="GET"class="d-flex-column">
                    <!-- row はグリッドシステムの1行を定義し、g-3 はその行内の列と列の間に3の幅分の間隔を設定する -->
                    <div class="row g-3">
                        <!-- col-mdは中サイズの画面で均等に幅が分割する -->
                        <div class="col-md">
                            <input type="text" class="form-control" id="product_name" placeholder="検索キーワード">
                        </div>
                        <div class="col-md">
                            <select class="form-select" aria-label="Default select example" id="company_id"
                                name="company_id">
                                <option value=""disabled selected>メーカ名を選択</option>
                                @foreach (\App\Models\Company::all() as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-auto">
                            <!-- 検索ボタン -->
                            <button type="submit" class="btn btn-primary">検索</button>
                        </div>
                    </div>
                </form>

                <!-- 新規登録ボタン mt-5マージントップ上に余白をつくる-->
                <table class="table table-bordered table-light table-primary mt-5">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>メーカー名</th>
                            <th></th>
                            <th></th>
                            <th>
                                <!-- mb-3マージンボトム下に余白をつくる -->
                                <div class="text-end mb-3">
                                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-warning">新規登録</a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <!-- asset()関数を使って、public/storageディレクトリ内の該当ファイルのパスを取得する -->
                                <td><img src="{{ asset('storage/' . $product->img_path) }}"alt="Product Image"
                                        style="width:100px"></td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->company_id }}</td>
                                <td>
                                    <a href="{{ route('products.show', $product) }}"class="btn btn-primary">詳細</a>
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product) }}"class="btn btn-primary btn-success">編集</a>
                                </td>
                                <td>
                                    <form action="{{ route('products.destroy', $product) }}"method="POST"
                                        onsubmit="return confirm('本当に削除しますか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- row 横方向のレイアウトをグループ化 -->
                <div class="row">
                    <!--親要素（row）を5つの等幅のカラムに分割-->
                    <div class="col-5">
                    </div>
                </div class="col-5">
                <!--php artisan vendor:publish --tag=laravel-paginationコマンド実行を忘れない-->
                {{ $products->links('vendor.pagination.bootstrap-4') }}
            </div>
            <div class="col-2">
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
