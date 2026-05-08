@if ($errors->has($field))
    <span class="text-red-600 text-sm">
        <i class="fas fa-exclamation-circle mr-1"></i>{{ $errors->first($field) }}
    </span>
@endif
