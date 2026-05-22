<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeekerRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'phone'         => ['required', 'string', 'max:15'],
            'experience'    => ['required', 'integer', 'min:0', 'max:50'],
            'notice_period' => ['required', 'integer', 'min:0', 'max:365'],
            'skills'        => ['required', 'array', 'min:1'],
            'skills.*'      => ['required', 'string', 'max:50'],
            'location_id'   => ['required', 'exists:locations,id'],
            'resume'        => ['required', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'photo'         => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
    }
}
