<?php

namespace App\Http\Controllers;

use App\Models\DataSubjectRecord;
use App\Models\DataSubjectRequest;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class DataSubjectRequestController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', DataSubjectRequest::class);

        $requests = DataSubjectRequest::with('dataSubjectRecord', 'createdBy', 'assignedTo')
            ->latest()
            ->paginate(15);

        return view('data-subject-requests.index', ['requests' => $requests]);
    }

    public function create()
    {
        $this->authorize('create', DataSubjectRequest::class);
        $records = DataSubjectRecord::all();
        return view('data-subject-requests.create', ['records' => $records]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', DataSubjectRequest::class);

        $validated = $request->validate([
            'data_subject_record_id' => 'required|exists:data_subject_records,id',
            'request_type' => 'required|in:access,deletion,rectification,portability,restrict_processing,object_processing',
            'status' => 'required|in:pending,in_progress,completed,rejected,withdrawn',
            'request_details' => 'nullable|string',
            'request_date' => 'nullable|date',
            'deadline_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $validated['created_by'] = auth()->id();
        if (!isset($validated['request_date'])) {
            $validated['request_date'] = now();
        }
        if (!isset($validated['deadline_date'])) {
            $validated['deadline_date'] = now()->addDays(config('pdpa.request_deadline_days', 30));
        }

        $dataRequest = DataSubjectRequest::create($validated);

        AuditLogService::logCreated($dataRequest, "Created {$dataRequest->request_type} request");

        return redirect()->route('data-subject-requests.show', $dataRequest)->with('success', 'Request created successfully.');
    }

    public function show(DataSubjectRequest $dataRequest)
    {
        $this->authorize('view', $dataRequest);
        $dataRequest->load('dataSubjectRecord', 'createdBy', 'assignedTo');
        return view('data-subject-requests.show', ['request' => $dataRequest]);
    }

    public function edit(DataSubjectRequest $dataRequest)
    {
        $this->authorize('update', $dataRequest);
        return view('data-subject-requests.edit', ['request' => $dataRequest]);
    }

    public function update(Request $request, DataSubjectRequest $dataRequest)
    {
        $this->authorize('update', $dataRequest);

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected,withdrawn',
            'response_details' => 'nullable|string',
            'rejection_reason' => 'nullable|string|required_if:status,rejected',
            'completed_date' => 'nullable|date|required_if:status,completed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $oldValues = $dataRequest->getAttributes();
        $dataRequest->update($validated);
        $newValues = $dataRequest->getAttributes();

        AuditLogService::logUpdated($dataRequest, $oldValues, $newValues, "Updated request status to {$dataRequest->status}");

        return redirect()->route('data-subject-requests.show', $dataRequest)->with('success', 'Request updated successfully.');
    }

    public function destroy(DataSubjectRequest $dataRequest)
    {
        $this->authorize('delete', $dataRequest);

        $requestType = $dataRequest->request_type;
        AuditLogService::logDeleted($dataRequest, "Deleted {$requestType} request");

        $dataRequest->delete();
        return redirect()->route('data-subject-requests.index')->with('success', 'Request deleted successfully.');
    }
}
