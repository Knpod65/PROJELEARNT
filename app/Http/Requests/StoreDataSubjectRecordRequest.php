<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataSubjectRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->is_active && in_array(auth()->user()->role, ['admin', 'staff']);
    }

    public function rules(): array
    {
        return [
            'record_code' => 'required|string|unique:data_subject_records|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:data_subject_records|max:255',
            'phone' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'data_category' => 'required|in:personal,financial,health,employment,other',
            'collection_purpose' => 'nullable|string|max:1000',
            'lawful_basis' => 'required|in:consent,contract,legal_obligation,vital_interests,public_task,legitimate_interests',
            'consent_status' => 'required|in:given,withdrawn,pending',
            'retention_until' => 'nullable|date|after:today',
            'status' => 'required|in:active,archived,pending_deletion',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'record_code.unique' => 'This record code already exists.',
            'email.unique' => 'This email address is already in our records.',
            'retention_until.after' => 'Retention date must be in the future.',
        ];
    }
}
