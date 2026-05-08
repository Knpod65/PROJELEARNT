@extends('layouts.app')

@section('title', 'Data Subject Records')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Data Subject Records</h1>
        <p class="text-gray-600">Manage data subject information and consent</p>
    </div>
    @can('create', App\Models\DataSubjectRecord::class)
        <a href="{{ route('records.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
            <i class="fas fa-plus mr-2"></i>Add Record
        </a>
    @endcan
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Data Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Consent</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Retention Until</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($records as $record)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $record->record_code }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $record->full_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ maskEmail($record->email) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $record->data_category)) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $record->consent_status === 'given' ? 'bg-green-100 text-green-800' : ($record->consent_status === 'withdrawn' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($record->consent_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $record->status === 'active' ? 'bg-blue-100 text-blue-800' : ($record->status === 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $record->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if($record->retention_until)
                                {{ $record->retention_until->format('Y-m-d') }}
                                @if($record->retention_until->diffInDays() <= 30)
                                    <span class="ml-2 text-yellow-600 font-semibold">EXPIRING</span>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            @can('view', $record)
                                <a href="{{ route('records.show', $record) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endcan
                            @can('update', $record)
                                <a href="{{ route('records.edit', $record) }}" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete', $record)
                                <form method="POST" action="{{ route('records.destroy', $record) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-600">
                            <i class="fas fa-inbox text-3xl mb-2 opacity-50"></i>
                            <p>No records found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($records->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $records->links() }}
        </div>
    @endif
</div>
@endsection
