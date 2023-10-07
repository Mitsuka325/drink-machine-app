@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">新規商品登録</h2>
                    </div>
                    <div class="card-body">
                        <!--フォーム内にファイルが含まれる場合は、必ずenctype="multipart/form-data"を指定する-->
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="product_name" class="form-label">商品名:</label>
                                <input type="text" class="form-control" id="product_name" name="product_name">
                            </div>
                            <div class="mb-3">
                                <label for="company_id" class="form-label">メーカー名:</label>
                                <select class="form-select" aria-label="Defalut select example" id="company_id"
                                    name="company_id">
                                    @foreach (\App\Models\Company::all() as $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">価格:</label>
                                <input type="number" class="form-control" id="price" name="price">
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">在庫数:</label>
                                <input type="number" class="form-control" id="stock" name="stock">
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">コメント:</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="img_path" class="form-label">商品画像:</label>
                                <input type="file" class="form-control" id="img_path" name="img_path">
                            </div>

                            <button type="submit" class="btn btn-primary">登録</button>
                            <a href="{{ route('products.index') }}"class="btn btn-secondary">戻る</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
