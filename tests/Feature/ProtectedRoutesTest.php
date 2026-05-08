<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProtectedRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard_without_a_server_error(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertOk();
    }

    public function test_admin_can_access_records_and_data_subject_requests(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->get('/records')->assertOk();
        $this->actingAs($admin)->get('/data-subject-requests')->assertOk();
    }

    public function test_viewer_cannot_access_audit_logs(): void
    {
        $viewer = User::factory()->create([
            'role' => 'viewer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($viewer)->get('/audit-logs');

        $response->assertForbidden();
    }
}
