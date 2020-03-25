<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeller extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'about' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'shipping' => 'required',
            'image' => 'nullable|image'
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
