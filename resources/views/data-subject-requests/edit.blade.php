@extends('layouts.app')
@section('title', 'Update Request')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Update Data Subject Request</h1>
</div>
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('data-subject-requests.update', $request) }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-2">Status *</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                @foreach(['pending', 'in_progress', 'completed', 'rejected', 'withdrawn'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $request->status) === $status)>
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>
            @include('partials.form-errors', ['field' => 'status'])
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-2">Response Details</label>
            <textarea name="response_details" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('response_details', $request->response_details) }}</textarea>
            @include('partials.form-errors', ['field' => 'response_details'])
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-2">Rejection Reason</label>
            <textarea name="rejection_reason" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('rejection_reason', $request->rejection_reason) }}</textarea>
            @include('partials.form-errors', ['field' => 'rejection_reason'])
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-2">Completed Date</label>
            <input type="date" name="completed_date" value="{{ old('completed_date', optional($request->completed_date)->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            @include('partials.form-errors', ['field' => 'completed_date'])
        </div>

        <div class="flex justify-end space-x-3 pt-6 border-t">
            <a href="{{ route('data-subject-requests.show', $request) }}" class="px-6 py-2 border border-gray-300 rounded-lg">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Update</button>
        </div>
    </form>
</div>
@endsection
