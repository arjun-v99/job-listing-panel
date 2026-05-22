<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isRecruiter();
    }

    public function rules(): array
    {
        return [
            'job_title'       => ['required', 'string', 'max:255'],
            'min_experience'  => ['required', 'integer', 'min:0', 'max:50'],
            'max_experience'  => ['required', 'integer', 'min:0', 'gte:min_experience'],
            'job_description' => ['required', 'string'],
            'skills_required' => ['required', 'array', 'min:1'],
            'skills_required.*' => ['required', 'string', 'max:50'],
            'location_id'     => ['required', 'exists:locations,id'],
            'status'          => ['required', 'in:active,inactive'],
        ];
    }
}
