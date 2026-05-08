@extends('layouts.app')

@section('title', 'Access Denied')

@section('content')
<div class="min-h-96 flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-900 mb-4">403</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Access Denied</h2>
        <p class="text-gray-600 mb-6">You do not have permission to access this resource.</p>
        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-home mr-2"></i>Return to Dashboard
        </a>
    </div>
</div>
@endsection
