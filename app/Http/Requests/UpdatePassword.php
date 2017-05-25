<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
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
            'old_password' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed|different:old_password',
            'password_confirmation' => 'required_with:password|string|min:8'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'old_password.required' => 'You must give your old password',
            'password.required' => 'A password is required to update',
            'password.min:8' => 'Your password needs to be longer than 8 characters',
            'password.confirmed' => 'Your confirmation didn\'t match, please try again',
        ];
    }
}
