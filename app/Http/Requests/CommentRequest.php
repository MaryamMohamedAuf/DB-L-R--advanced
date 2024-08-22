<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'feedback' => 'nullable|string',
            'decision' => 'nullable|in:accepted,rejected',
            'user_id' => 'required|integer',
            'cohort_id' => 'required|integer',
            'applicant_id'=> 'required|integer',
            'round1_id'=> 'nullable|integer',
            'round2_id'=> 'nullable|integer',
            'round3_id'=> 'nullable|integer',
            'round_type'=> 'required|string'

        ];
    }
}
