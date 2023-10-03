@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">商品編集</h2>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="id" class="form-label">ID:{{ $product->id }}</label>
                            </div>
                            <div class="mb-3">
                                <label for="product_name" class="form-label">商品名:</label>
                                <input type="text" class="form-control" id="product_name" name="product_name"
                                    value="{{ $product->product_name }}">
                            </div>

                            <div class="mb-3">
                                <label for="company_id" class="form-label">メーカー名:</label>
                                <select class="form-select" aria-label="Default select example" id="company_id"
                                    name="company_id">
                                    @foreach (\App\Models\Company::all() as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $company->id == $product->company_id ? 'selected' : '' }}>
                                            {{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">価格:</label>
                                <input type="number" class="form-control" id="price" name="price"
                                    value="{{ $product->price }}">
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">在庫数:</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                    value="{{ $product->stock }}">
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">コメント:</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3">{{ $product->comment }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="img_path" class="form-label">商品画像:</label>
                                <input type="file" class="form-control" id="img_path" name="img_path">
                            </div>

                            <button type="submit" class="btn btn-primary btn-success">更新</button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
