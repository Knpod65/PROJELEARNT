<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-900 mb-2">Record Code *</label>
        <input type="text" name="record_code" value="{{ old('record_code', $record->record_code ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        @include('partials.form-errors', ['field' => 'record_code'])
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-900 mb-2">Full Name *</label>
        <input type="text" name="full_name" value="{{ old('full_name', $record->full_name ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        @include('partials.form-errors', ['field' => 'full_name'])
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-900 mb-2">Email *</label>
        <input type="email" name="email" value="{{ old('email', $record->email ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        @include('partials.form-errors', ['field' => 'email'])
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-900 mb-2">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $record->phone ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-900 mb-2">Department</label>
        <input type="text" name="department" value="{{ old('department', $record->department ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-900 mb-2">Data Category *</label>
        <select name="data_category" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            <option value="">Select Category</option>
            @foreach(['personal' => 'Personal', 'financial' => 'Financial', 'health' => 'Health', 'employment' => 'Employment', 'other' => 'Other'] as $val => $label)
                <option value="{{ $val }}" {{ old('data_category', $record->data_category ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-900 mb-2">Lawful Basis *</label>
    <select name="lawful_basis" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        <option value="">Select Basis</option>
        @foreach(['consent' => 'Consent', 'contract' => 'Contract', 'legal_obligation' => 'Legal Obligation', 'vital_interests' => 'Vital Interests', 'public_task' => 'Public Task', 'legitimate_interests' => 'Legitimate Interests'] as $val => $label)
            <option value="{{ $val }}" {{ old('lawful_basis', $record->lawful_basis ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-900 mb-2">Consent Status *</label>
        <select name="consent_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            <option value="">Select Status</option>
            @foreach(['given' => 'Given', 'withdrawn' => 'Withdrawn', 'pending' => 'Pending'] as $val => $label)
                <option value="{{ $val }}" {{ old('consent_status', $record->consent_status ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-900 mb-2">Status *</label>
        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            <option value="">Select Status</option>
            @foreach(['active' => 'Active', 'archived' => 'Archived', 'pending_deletion' => 'Pending Deletion'] as $val => $label)
                <option value="{{ $val }}" {{ old('status', $record->status ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-900 mb-2">Retention Until</label>
    <input type="date" name="retention_until" value="{{ old('retention_until', $record->retention_until ? $record->retention_until->format('Y-m-d') : '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
</div>

<div>
    <label class="block text-sm font-medium text-gray-900 mb-2">Notes</label>
    <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('notes', $record->notes ?? '') }}</textarea>
</div>
