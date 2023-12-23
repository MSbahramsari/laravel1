<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use function Laravel\Prompts\password;

class RegisterUserRequest extends FormRequest
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
            'email'=>'required',
            'password'=>'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation'=>'min:8',
            'checkbox'=>'accepted'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); // Here is your array of errors
        $redirect = redirect()->back()
            ->withInput()
            ->withErrors($errors);

        throw new HttpResponseException($redirect);
    }
}
