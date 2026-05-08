@extends('layouts.app')
@section('title', 'Create Request')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Create Data Subject Request</h1>
</div>
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('data-subject-requests.store') }}" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-900 mb-2">Data Subject Record *</label>
            <select name="data_subject_record_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                <option value="">Select Record</option>
                @foreach(\App\Models\DataSubjectRecord::all() as $r)
                    <option value="{{ $r->id }}">{{ $r->full_name }}</option>
                @endforeach
            </select>
            @include('partials.form-errors', ['field' => 'data_subject_record_id'])
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900 mb-2">Request Type *</label>
            <select name="request_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                <option value="">Select Type</option>
                @foreach(['access' => 'Access', 'deletion' => 'Deletion', 'rectification' => 'Rectification', 'portability' => 'Portability', 'restrict_processing' => 'Restrict', 'object_processing' => 'Object'] as $val => $label)
                    <option value="{{ $val }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-900 mb-2">Details</label>
            <textarea name="request_details" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
        </div>
        <div class="flex justify-end space-x-3 pt-6 border-t">
            <a href="{{ route('data-subject-requests.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Create</button>
        </div>
    </form>
</div>
@endsection
