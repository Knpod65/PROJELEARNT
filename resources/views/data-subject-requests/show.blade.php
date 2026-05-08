@extends('layouts.app')
@section('title', 'View Request')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Data Subject Request</h1>
</div>
<div class="bg-white rounded-lg shadow p-6 max-w-2xl space-y-4">
    <div><label class="text-sm text-gray-500">Record</label><p class="text-lg font-semibold">{{ $request->dataSubjectRecord->full_name }}</p></div>
    <div><label class="text-sm text-gray-500">Type</label><p>{{ ucfirst(str_replace('_', ' ', $request->request_type)) }}</p></div>
    <div><label class="text-sm text-gray-500">Status</label><span class="px-3 py-1 rounded text-sm font-semibold bg-blue-100 text-blue-800">{{ ucfirst(str_replace('_', ' ', $request->status)) }}</span></div>
    <div><label class="text-sm text-gray-500">Date</label><p>{{ $request->request_date?->format('Y-m-d') ?? '-' }}</p></div>
    <div><label class="text-sm text-gray-500">Deadline</label><p>{{ $request->deadline_date?->format('Y-m-d') ?? '-' }}</p></div>
    <div><label class="text-sm text-gray-500">Details</label><p class="whitespace-pre-wrap">{{ $request->request_details ?? '-' }}</p></div>
</div>
<div class="mt-4">
    <a href="{{ route('data-subject-requests.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg">Back</a>
</div>
@endsection
