<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\DataSubjectRecord;
use App\Models\DataSubjectRequest;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $recordStatusLabels = config('pdpa.record_status', []);
        $consentStatusLabels = config('pdpa.consent_status', []);
        $requestStatusLabels = config('pdpa.request_status', []);

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

        $recordsByStatus = DataSubjectRecord::query()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->map(fn ($count) => (int) $count)
            ->all();

        $recordsByConsentStatus = DataSubjectRecord::query()
            ->select('consent_status', DB::raw('count(*) as count'))
            ->groupBy('consent_status')
            ->pluck('count', 'consent_status')
            ->map(fn ($count) => (int) $count)
            ->all();

        $requestsByStatus = DataSubjectRequest::query()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->map(fn ($count) => (int) $count)
            ->all();

        return view('dashboard.index', [
            'totalRecords' => $totalRecords,
            'activeRecords' => $activeRecords,
            'expiringRecords' => $expiringRecords,
            'totalRequests' => $totalRequests,
            'pendingRequests' => $pendingRequests,
            'overdueRequests' => $overdueRequests,
            'recentLogs' => $recentLogs,
            'recordStatusLabels' => $recordStatusLabels,
            'consentStatusLabels' => $consentStatusLabels,
            'requestStatusLabels' => $requestStatusLabels,
            'recordsByStatus' => $recordsByStatus,
            'recordsByConsentStatus' => $recordsByConsentStatus,
            'requestsByStatus' => $requestsByStatus,
        ]);
    }
}
