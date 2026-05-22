<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecruiterRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'phone'        => ['required', 'string', 'max:15'],
            'address'      => ['required', 'string', 'max:500'],
        ];
    }
}
