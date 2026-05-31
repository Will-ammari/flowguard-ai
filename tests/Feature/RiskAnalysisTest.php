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
    }
}
