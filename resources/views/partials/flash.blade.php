@if ($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center mb-2">
            <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
            <h3 class="text-sm font-semibold text-red-900">Validation Errors</h3>
        </div>
        <ul class="list-disc list-inside text-sm text-red-800">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
        <i class="fas fa-check-circle text-green-600 mr-2"></i>
        <span class="text-sm text-green-800">{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center">
        <i class="fas fa-times-circle text-red-600 mr-2"></i>
        <span class="text-sm text-red-800">{{ session('error') }}</span>
    </div>
@endif

@if (session('warning'))
    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg flex items-center">
        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
        <span class="text-sm text-yellow-800">{{ session('warning') }}</span>
    </div>
@endif
