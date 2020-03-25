<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'origin' => 'required|numeric',
            'name' => 'required',
            'product_description' => 'required',
            'unit_id' => 'required',
            'price' => 'required|numeric',
            'lowest' => 'required|numeric',
            'category_id' => 'required|numeric',
            'sub_id' => 'required|numeric',
            'image' => 'required|image'
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'الصورة الرئيسية مطلوبة',
            'image.image' => 'يجب اختيار صورة صحيحة',
        ];
    }
}
