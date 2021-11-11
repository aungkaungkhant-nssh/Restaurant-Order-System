<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChefsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            "name"=>"required",
            "email"=>"required|email|unique:users,email",
            "phone"=>"required|unique:users,phone",
            "password"=>"required|min:8|max:16",
            "address"=>"required"
        ];
    }
    public function messages()
    {
        return[
            "name.required"=>"အမည်ထည့်ပေးပါ",
            "email.required"=>"အီးမေးလ်ထည့်ပေးပါ",
            "email.email"=>"မှန်ကန်သည့်အီးမေးလ်ထည့်ပေးပါ",
            "email.unique"=>"ဒီ အီးမေးလ်သည့် လိပ်စာ သည်ရှိပြီသားဖြစ်သည်",
            "phone.required"=>"ဖုန်းနံပါတ်ထည့်ပေးပါ",
            "email.unique"=>"ဒီ ဖုန်းနံပါတ် သည်ရှိပြီသားဖြစ်သည်",
            "password.required"=>"ပက်စ်ဝေါ့ထည့်ပေးပါ",
            "password.min"=>"ပက်စ်ဝေါ့သည် အနည်းဆုံး ၈ လုံး ရှိ ရမည်",
            "password.max"=>"ပက်စ်ဝေါ့သည် ၁၆ လုံးထက် မပို ရ",
            "address.required"=>"နေရပ်လိပ်စာထည့်ပေးပါ"
        ];
    }
}
