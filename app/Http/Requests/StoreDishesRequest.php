<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDishesRequest extends FormRequest
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
            "name"=>"required",
            "category_id"=>"required|integer",
            "image"=>"required|image|mimes:jpg,png,jpeg",
            "price"=>"required|numeric"
        ];
    }
    public function messages()
    {
        return [
            "name.required"=>"အစားအစာ အမည်ထည့်ပေးပါ",
            "category_id.required"=>"အမျိုးအစားအမည် ရွေးပေးပါ",
            "image.required"=>"ဓာတ်ပုံထည့်ပေးပါ",
            "image.mimes"=>"ဓာတ်ပုံ အမျိုးအစား သည် png,jpg,jpeg ဖြစ်ရမည်",
            "price.required"=>"ဈေးနှုန်းထည့်ပေးပါ",
            "price.numeric"=>"ဒသမကိန်းဖြင့်ထည့်ပေးပါ"
        ];
    }
}
