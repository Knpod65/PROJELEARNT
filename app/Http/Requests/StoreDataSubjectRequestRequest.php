<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataSubjectRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->is_active && in_array(auth()->user()->role, ['admin', 'staff']);
    }

    public function rules(): array
    {
        return [
            'data_subject_record_id' => 'required|exists:data_subject_records,id',
            'request_type' => 'required|in:access,deletion,rectification,portability,restrict_processing,object_processing',
            'request_details' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,in_progress,completed,rejected,withdrawn',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'data_subject_record_id.required' => 'Please select a data subject record.',
            'data_subject_record_id.exists' => 'The selected record does not exist.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('status')) {
            $this->merge(['status' => 'pending']);
        }
    }
}
