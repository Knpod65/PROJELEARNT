@extends('layouts.app')
@section('title', 'Create Data Subject Record')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Data Subject Record</h1>
</div>
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route('records.store') }}" class="space-y-6">
        @csrf
        @include('records._form_fields')
        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
            <a href="{{ route('records.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Create Record</button>
        </div>
    </form>
</div>
@endsection
