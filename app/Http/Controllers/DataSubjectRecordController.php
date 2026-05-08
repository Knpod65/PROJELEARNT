<?php

namespace App\Http\Controllers;

use App\Models\DataSubjectRecord;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class DataSubjectRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('viewAny', DataSubjectRecord::class);

        $records = DataSubjectRecord::with('createdBy')
            ->latest()
            ->paginate(15);

        return view('records.index', ['records' => $records]);
    }

    public function create()
    {
        $this->authorize('create', DataSubjectRecord::class);
        return view('records.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', DataSubjectRecord::class);

        $validated = $request->validate([
            'record_code' => 'required|string|unique:data_subject_records',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:data_subject_records',
            'phone' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'data_category' => 'required|in:personal,financial,health,employment,other',
            'collection_purpose' => 'nullable|string',
            'lawful_basis' => 'required|in:consent,contract,legal_obligation,vital_interests,public_task,legitimate_interests',
            'consent_status' => 'required|in:given,withdrawn,pending',
            'retention_until' => 'nullable|date',
            'status' => 'required|in:active,archived,pending_deletion',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();
        $record = DataSubjectRecord::create($validated);

        AuditLogService::logCreated($record, "Created record for {$record->full_name}");

        return redirect()->route('records.show', $record)->with('success', 'Record created successfully.');
    }

    public function show(DataSubjectRecord $record)
    {
        $this->authorize('view', $record);
        $record->load('createdBy', 'requests');
        return view('records.show', ['record' => $record]);
    }

    public function edit(DataSubjectRecord $record)
    {
        $this->authorize('update', $record);
        return view('records.edit', ['record' => $record]);
    }

    public function update(Request $request, DataSubjectRecord $record)
    {
        $this->authorize('update', $record);

        $validated = $request->validate([
            'record_code' => 'required|string|unique:data_subject_records,record_code,' . $record->id,
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:data_subject_records,email,' . $record->id,
            'phone' => 'nullable|string|max:50',
            'department' => 'nullable|string|max:255',
            'data_category' => 'required|in:personal,financial,health,employment,other',
            'collection_purpose' => 'nullable|string',
            'lawful_basis' => 'required|in:consent,contract,legal_obligation,vital_interests,public_task,legitimate_interests',
            'consent_status' => 'required|in:given,withdrawn,pending',
            'retention_until' => 'nullable|date',
            'status' => 'required|in:active,archived,pending_deletion',
            'notes' => 'nullable|string',
        ]);

        $oldValues = $record->getAttributes();
        $validated['updated_by'] = auth()->id();
        $record->update($validated);
        $newValues = $record->getAttributes();

        AuditLogService::logUpdated($record, $oldValues, $newValues, "Updated record for {$record->full_name}");

        return redirect()->route('records.show', $record)->with('success', 'Record updated successfully.');
    }

    public function destroy(DataSubjectRecord $record)
    {
        $this->authorize('delete', $record);

        $fullName = $record->full_name;
        AuditLogService::logDeleted($record, "Deleted record for {$fullName}");

        $record->delete();
        return redirect()->route('records.index')->with('success', 'Record deleted successfully.');
    }
}
