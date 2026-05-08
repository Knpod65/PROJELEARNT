<?php

namespace Tests\Feature;

use App\Models\DataSubjectRecord;
use App\Models\DataSubjectRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_renders_numeric_grouped_counts_without_raw_objects(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $record = DataSubjectRecord::create([
            'record_code' => 'REC-001',
            'full_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'data_category' => 'personal',
            'lawful_basis' => 'consent',
            'consent_status' => 'given',
            'status' => 'active',
            'created_by' => $admin->id,
        ]);

        DataSubjectRequest::create([
            'data_subject_record_id' => $record->id,
            'request_type' => 'access',
            'status' => 'pending',
            'request_date' => now()->toDateString(),
            'deadline_date' => now()->addDays(30)->toDateString(),
            'created_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertOk();
        $response->assertDontSee('{"status":"active"', false);
        $response->assertDontSee('{"consent_status":"given"', false);
        $response->assertDontSee('{"status":"pending"', false);
    }
}
