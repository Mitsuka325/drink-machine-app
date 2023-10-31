@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-md-10 text-end">

                <!-- 検索フォーム --Flexboxを使ってコンテンツを縦方向に並べる-->

                <form id="search-form" action="{{ route('products.index') }}"method="GET" class="d-flex-column">
                    <!-- row はグリッドシステムの1行を定義し、g-3 はその行内の列と列の間に3の幅分の間隔を設定する -->
                    <div class="row g-3">
                        <!-- col-mdは中サイズの画面で均等に幅が分割する -->
                        <div class="col-md">
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                placeholder="検索キーワード">
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
                    <div class="container-lg mt-3"><!--マージン追加-->
                        <div class="row g-1">
                            <div class="col-auto">
                                <select class="form-select" aria-label="価格を選択" id="price_range" name="price_range">

                                    <option value="" disabled selected>価格を選択</option>
                                    <option value="0-100">0円 - 100円</option>
                                    <option value="100-200">100円 - 200円</option>
                                    <option value="200-300">200円 - 300円</option>
                                    <option value="300-400">300円 - 400円</option>
                                    <option value="400-500">400円 - 500円</option>
                                </select>
                                min:{{ \App\Models\Product::all()->min('price') }}~max:{{ \App\Models\Product::all()->max('price') }}
                            </div>
                        </div>
                        <div class="row g-1">
                            <div class="col-auto">
                                <select class="form-select" aria-label="在庫数を選択"id="stock_range" name="stock_range">
                                    <option value=""disabled selected>在庫数を選択</option>
                                    <option value="0-10">0個 -10個</option>
                                    <option value="10-20">10個 -20個</option>
                                    <option value="20-30">20個 -30個</option>
                                    <option value="30-40">30個 -40個</option>
                                    <option value="40-50">40個 -50個</option>
                                </select>
                                min:{{ \App\Models\Product::all()->min('stock') }}~max:{{ \App\Models\Product::all()->max('stock') }}
                            </div>
                        </div>
                </form>
                <!--エラーメッセージ表示-->
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <!-- 新規登録ボタン mt-5マージントップ上に余白をつくる-->
                <table class="table table-bordered table-light table-primary mt-5">
                    <thead>
                        <tr>
                            <th>id
                                <a href="/products?sort_column=id&sort_direct=asc&page={{ request()->page }}">▲</a>
                                <a href="/products?sort_column=id&sort_direct=desc&page={{ request()->page }}">▼</a>
                            </th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>価格
                                <a href="/products?sort_column=price&sort_direct=asc&page={{ request()->page }}">▲</a>
                                <a href="/products?sort_column=price&sort_direct=desc&page={{ request()->page }}">▼</a>
                            </th>
                            <th>
                                在庫数
                                <a href="/products?sort_column=stock&sort_direct=asc&page={{ request()->page }}">▲</a>
                                <a href="/products?sort_column=stock&sort_direct=desc&page={{ request()->page }}">▼</a>
                            </th>
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
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const headers = document.querySelectorAll('th[data-sortable]');
                            headers.forEach(header => {
                                header.addEventListener('click', () => {
                                    const column = header.dataset.sortable;
                                    const currentDirection = header.dataset.sortDirection || 'asc';
                                    const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
                                    const url = new URL(window.location);
                                    url.searchParams.set('sort_column', column);
                                    url.searchParams.set('sort_direction', newDirection);
                                    window.location.href = url.toString();
                                });
                            });
                        });
                    </script>
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
                                <td>{{ $product->company->company_name }}</td>
                                <td>
                                    <a href="{{ route('products.show', $product) }}"class="btn btn-primary">詳細</a>
                                </td>
                                <td>
                                    <a
                                        href="{{ route('products.edit', $product) }}"class="btn btn-primary btn-success">編集</a>
                                </td>
                                <td>
                                    <button class="btn btn-danger delete-product"
                                        data-product-id="{{ $product->id }}">削除</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <script src="{{ asset('js/app.js') }}"></script>
                <!-- row 横方向のレイアウトをグループ化 -->
                <div class="row">
                    <!--親要素（row）を5つの等幅のカラムに分割-->
                    <div class="col-5">
                    </div>
                    <div class="col-5">
                        <!--php artisan vendor:publish --tag=laravel-paginationコマンド実行を忘れない-->
                        {{ $products->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
            <div class="col-2">
            </div>
        </div>
    </div>
    <script>
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            // 検索フォームのデータをサーバーに送信し、結果を非同期で取得
            $.ajax({
                url: "{{ route('products.index') }}", // 一覧表示を更新するためのルート
                type: "GET",
                data: formData,
                dataType: "json", // 応答データの形式はJSON
                success: function(products) {
                    // 取得したデータを使用して一覧を更新
                    updateProductList(products);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
        // 商品一覧を更新する関数
        function updateProductList(products) {
            const tableBody = $('tbody');
            tableBody.empty(); // テーブルの内容をクリア
            products.forEach(product => {
                const row = $('<tr>');
                row.html(`
            <td>${product.id}</td>
            <td><img src="storage/${product.img_path}" alt="Product Image" style="width:100px"></td>
            <td>${product.product_name}</td>
            <td>${product.price}</td>
            <td>${product.stock}</td>
            <td>${product.company.company_name}</td>
            <td>
                <a href="/products/${product.id}" class="btn btn-primary">詳細</a>
            </td>
            <td>
                <a href="/products/${product.id}/edit" class="btn btn-primary btn-success">編集</a>
            </td>
            <td>
                
                    <button class="btn btn-danger delete-product" data-product-id="${product.id}">削除</button>
            </td>
        `);
                tableBody.append(row);
            });
        }
        // 商品を削除する Ajax リクエスト
        $('body').on('click', '.delete-product', function() {
            var productID = $(this).data('product-id');
            var button = $(this);
            if (confirm('本当に削除しますか？')) {
                $.ajax({
                    type: 'POST',
                    url: '/products/' + productID,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        '_method':'DELETE'
                    },
                    dataType: 'json', // JSON形式のレスポンスを期待
                    success: function(response) {
                        // 削除が成功した場合、JSON形式のレスポンスを返し、必要な処理を行う。
                        if (response.success) {
                            button.closest('tr').remove();
                        } else {
                            console.error(response.message); // エラーメッセージをコンソールに表示
                        }
                    },
                    error: function(xhr) {
                        // エラー処理
                        console.error(xhr);
                    }
                });
            }
        });
    </script>
@endsection
