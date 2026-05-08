<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\DataSubjectRecord;
use App\Models\DataSubjectRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRecords = DataSubjectRecord::count();
        $activeRecords = DataSubjectRecord::where('status', 'active')->count();
        $expiringRecords = DataSubjectRecord::retentionExpiringSoon()->count();
        $totalRequests = DataSubjectRequest::count();
        $pendingRequests = DataSubjectRequest::pending()->count();
        $overdueRequests = DataSubjectRequest::overdue()->count();

        $recentLogs = AuditLog::with('user')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $recordsByStatus = DataSubjectRecord::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->orderBy('count', 'desc')
            ->get()
            ->keyBy('status');

        $recordsByConsent = DataSubjectRecord::selectRaw('consent_status, COUNT(*) as count')
            ->groupBy('consent_status')
            ->orderBy('count', 'desc')
            ->get()
            ->keyBy('consent_status');

        $requestsByStatus = DataSubjectRequest::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->orderBy('count', 'desc')
            ->get()
            ->keyBy('status');

        return view('dashboard.index', [
            'totalRecords' => $totalRecords,
            'activeRecords' => $activeRecords,
            'expiringRecords' => $expiringRecords,
            'totalRequests' => $totalRequests,
            'pendingRequests' => $pendingRequests,
            'overdueRequests' => $overdueRequests,
            'recentLogs' => $recentLogs,
            'recordsByStatus' => $recordsByStatus,
            'recordsByConsent' => $recordsByConsent,
            'requestsByStatus' => $requestsByStatus,
        ]);
    }
}
