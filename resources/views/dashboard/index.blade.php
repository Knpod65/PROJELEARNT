@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
    <p class="text-gray-600">Overview of data subject records and requests</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm">Total Records</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalRecords ?? 0 }}</p>
            </div>
            <i class="fas fa-database text-blue-600 text-2xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm">Active Records</p>
                <p class="text-3xl font-bold text-gray-900">{{ $activeRecords ?? 0 }}</p>
            </div>
            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-600">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm">Expiring Soon</p>
                <p class="text-3xl font-bold text-gray-900">{{ $expiringRecords ?? 0 }}</p>
            </div>
            <i class="fas fa-clock text-yellow-600 text-2xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-600">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm">Pending Requests</p>
                <p class="text-3xl font-bold text-gray-900">{{ $pendingRequests ?? 0 }}</p>
            </div>
            <i class="fas fa-file-alt text-purple-600 text-2xl"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Records by Status</h2>
        <div class="space-y-3">
            @foreach($recordStatusLabels as $status => $label)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ $label }}</span>
                    <span class="font-semibold text-gray-900">{{ $recordsByStatus[$status] ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Records by Consent</h2>
        <div class="space-y-3">
            @foreach($consentStatusLabels as $consent => $label)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ $label }}</span>
                    <span class="font-semibold text-gray-900">{{ $recordsByConsentStatus[$consent] ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Requests by Status</h2>
        <div class="space-y-3">
            @foreach($requestStatusLabels as $status => $label)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">{{ $label }}</span>
                    <span class="font-semibold text-gray-900">{{ $requestsByStatus[$status] ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h2>
        @forelse($recentLogs as $log)
            <div class="py-3 border-b border-gray-200 last:border-b-0">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $log->action }}</p>
                        <p class="text-xs text-gray-600">{{ $log->user->name ?? 'System' }} - {{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-sm">No recent activity</p>
        @endforelse
    </div>
</div>
@endsection
