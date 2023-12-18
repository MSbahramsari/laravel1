<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

                'user_name'=>'required|max:20',
                'last_name'=>'required|max:255',
                'first_name'=>'required|max:255' ,
                'age'=>'required|integer|min:18',
                'gender'=>'required',
                'email'=>'required',
                'phone_number'=>'required|min:11|max:11',
                'password'=>'required|min:8',
                'address'=>'required',
                'postal_code'=>'required',
                'province'=>'required',
                'city'=>'required',

        ];
    }
}
