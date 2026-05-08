@extends('layouts.app')
@section('title', 'Data Subject Requests')
@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Data Subject Requests</h1>
        <p class="text-gray-600">Manage PDPA data subject requests</p>
    </div>
    @can('create', App\Models\DataSubjectRequest::class)
        <a href="{{ route('data-subject-requests.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>New Request
        </a>
    @endcan
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold">Record</th>
                <th class="px-6 py-3 text-left text-xs font-semibold">Type</th>
                <th class="px-6 py-3 text-left text-xs font-semibold">Status</th>
                <th class="px-6 py-3 text-left text-xs font-semibold">Deadline</th>
                <th class="px-6 py-3 text-left text-xs font-semibold">Assigned To</th>
                <th class="px-6 py-3 text-left text-xs font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($requests as $request)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $request->dataSubjectRecord->full_name }}</td>
                    <td class="px-6 py-4 text-sm">{{ ucfirst(str_replace('_', ' ', $request->request_type)) }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $request->deadline_date?->format('Y-m-d') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $request->assignedTo->name ?? 'Unassigned' }}</td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="{{ route('data-subject-requests.show', $request) }}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i>
                        </a>
                        @can('update', $request)
                            <a href="{{ route('data-subject-requests.edit', $request) }}" class="text-green-600 hover:text-green-900">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-600">No requests found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($requests->hasPages())
    <div class="mt-4">{{ $requests->links() }}</div>
@endif
@endsection
