<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataSubjectRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->is_active && in_array(auth()->user()->role, ['admin', 'staff']);
    }

    public function rules(): array
    {
        return [
            'request_type' => 'required|in:access,deletion,rectification,portability,restrict_processing,object_processing',
            'status' => 'required|in:pending,in_progress,completed,rejected,withdrawn',
            'request_details' => 'nullable|string|max:1000',
            'response_details' => 'nullable|string|max:1000',
            'rejection_reason' => 'nullable|string|max:1000|required_if:status,rejected',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'rejection_reason.required_if' => 'Rejection reason is required when status is rejected.',
        ];
    }
}
