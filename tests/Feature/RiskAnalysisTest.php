<?php

namespace Tests\Feature;

use App\Enums\StepType;
use App\Models\Workflow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RiskAnalysisTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_detects_ai_personal_data_risk(): void
    {
        $workflow = Workflow::create([
            'title' => 'Test AI Support Workflow',
            'description' => 'Test workflow',
            'industry' => 'Customer Support',
        ]);

        $workflow->steps()->create([
            'step_order' => 1,
            'name' => 'LLM drafts reply',
            'step_type' => StepType::AI_PROCESSING,
            'uses_ai' => true,
            'uses_personal_data' => true,
            'is_customer_facing' => false,
            'has_human_review' => false,
            'has_audit_log' => false,
            'has_fallback_path' => false,
        ]);

        $response = $this->postJson("/api/v1/workflows/{$workflow->id}/analyze");

        $response->assertOk()
            ->assertJsonPath('overall_risk_level', 'Medium')
            ->assertJsonFragment(['risk_code' => 'AI_PERSONAL_DATA']);

        $this->assertDatabaseHas('audit_logs', [
            'workflow_id' => $workflow->id,
            'action' => 'workflow_analyzed',
        ]);
    }

    public function test_it_detects_missing_audit_trail_risk(): void
    {
        $workflow = Workflow::create([
            'title' => 'No Audit Workflow',
            'industry' => 'Finance',
        ]);

        $workflow->steps()->create([
            'step_order' => 1,
            'name' => 'AI sends customer recommendation',
            'step_type' => StepType::AI_PROCESSING,
            'uses_ai' => true,
            'uses_personal_data' => true,
            'has_audit_log' => false,
            'has_human_review' => true,
            'has_fallback_path' => true,
        ]);

        $response = $this->postJson("/api/v1/workflows/{$workflow->id}/analyze");

        $response->assertOk()
            ->assertJsonFragment(['risk_code' => 'MISSING_AUDIT_TRAIL']);
    }

    public function test_it_detects_irreversible_automation_without_review(): void
    {
        $workflow = Workflow::create([
            'title' => 'Irreversible Automation Workflow',
            'industry' => 'Operations',
        ]);

        $workflow->steps()->create([
            'step_order' => 1,
            'name' => 'AI cancels customer order',
            'step_type' => StepType::DECISION,
            'uses_ai' => true,
            'is_irreversible_action' => true,
            'has_human_review' => false,
            'has_audit_log' => false,
            'has_fallback_path' => false,
        ]);

        $response = $this->postJson("/api/v1/workflows/{$workflow->id}/analyze");

        $response->assertOk()
            ->assertJsonFragment(['risk_code' => 'IRREVERSIBLE_AUTOMATION_WITHOUT_APPROVAL']);
    }
}