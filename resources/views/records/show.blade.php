@extends('layouts.app')
@section('title', 'View Data Subject Record')
@section('content')
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-900">Data Subject Record</h1>
    <div class="flex space-x-2">
        @can('update', $record)
            <a href="{{ route('records.edit', $record) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Edit</a>
        @endcan
        <a href="{{ route('records.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg">Back</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div><label class="text-sm text-gray-500">Code</label><p class="font-semibold">{{ $record->record_code }}</p></div>
            <div><label class="text-sm text-gray-500">Name</label><p class="font-semibold">{{ $record->full_name }}</p></div>
            <div><label class="text-sm text-gray-500">Email</label><p>{{ maskEmail($record->email) }}</p></div>
            <div><label class="text-sm text-gray-500">Phone</label><p>{{ $record->phone ? maskPhone($record->phone) : '-' }}</p></div>
            <div><label class="text-sm text-gray-500">Category</label><p>{{ ucfirst(str_replace('_', ' ', $record->data_category)) }}</p></div>
            <div><label class="text-sm text-gray-500">Basis</label><p>{{ ucfirst(str_replace('_', ' ', $record->lawful_basis)) }}</p></div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 space-y-3">
        <div><label class="text-sm text-gray-500 block">Status</label><span class="px-3 py-1 rounded text-sm font-semibold bg-blue-100 text-blue-800">{{ ucfirst($record->status) }}</span></div>
        <div><label class="text-sm text-gray-500 block">Consent</label><span class="px-3 py-1 rounded text-sm font-semibold {{ $record->consent_status === 'given' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($record->consent_status) }}</span></div>
        <div><label class="text-sm text-gray-500 block">Retention</label><p>{{ $record->retention_until?->format('Y-m-d') ?? '-' }}</p></div>
        <div><label class="text-sm text-gray-500 block">Created</label><p class="text-sm">{{ $record->created_at->format('Y-m-d H:i') }}</p></div>
    </div>
</div>
@endsection
