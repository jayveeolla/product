<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeekRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('store week');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_title' => 'required',
            'price' => 'required',
            'quanity' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:1000',
            'sku' => 'nullable',
            'product_ingredients' => 'required',
        ];
    }
}
