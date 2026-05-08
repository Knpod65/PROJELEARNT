@extends('layouts.app')
@section('title', 'Audit Logs')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Audit Logs</h1>
</div>
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold">User</th>
                <th class="px-6 py-3 text-left text-xs font-semibold">Action</th>
                <th class="px-6 py-3 text-left text-xs font-semibold">Model</th>
                <th class="px-6 py-3 text-left text-xs font-semibold">Description</th>
                <th class="px-6 py-3 text-left text-xs font-semibold">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">{{ $log->user->name ?? 'System' }}</td>
                    <td class="px-6 py-4 text-sm font-medium">{{ $log->action }}</td>
                    <td class="px-6 py-4 text-sm">{{ $log->model_type }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $log->description ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-600">No logs found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($logs->hasPages())
    <div class="mt-4">{{ $logs->links() }}</div>
@endif
@endsection
