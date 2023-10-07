<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => 'required|max:255',
            'company_id' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'comment' => 'max:10000',
        ];
    }

    public function attributes()
    {
        return [
            'product_name' => '商品名',
            'price' => '価格',
            'stock' => '在庫',
            'comment' => 'コメント',
        ];
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product_name.required' => ':attributeは必須項目です。',
            'product_name.max' => ':attributeは:max文字以内で入力してください。',
            'price.required' => ':attributeは必須項目です。',
            'price.integer' => ':attributeは整数を入力してください。',
            'stock.required' => ':attributeは必須項目です。',
            'stock.integer' => ':attributeは整数を入力してください。',
            'comment.max' => ':attributeは:max文字以内で入力してください。',
        ];
    }
}
