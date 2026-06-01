<?php

namespace Tests\Feature;

use App\Models\Workflow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_workflow_audit_logs(): void
    {
        $workflow = Workflow::create([
            'title' => 'Audit Test Workflow',
            'industry' => 'Compliance',
        ]);

        $this->putJson("/api/v1/workflows/{$workflow->id}", [
            'title' => 'Audit Test Workflow Updated',
        ])->assertOk();

        $response = $this->getJson("/api/v1/workflows/{$workflow->id}/audit-logs");

        $response->assertOk();
        $response->assertJsonFragment([
            'action' => 'updated',
            'workflow_id' => $workflow->id,
        ]);
    }
}