<?php

namespace Tests\Feature;

use App\Enums\StepType;
use App\Models\Workflow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkflowApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_workflow_with_steps(): void
    {
        $response = $this->postJson('/api/v1/workflows', [
            'title' => 'AI Customer Support Workflow',
            'description' => 'A workflow for support automation.',
            'industry' => 'E-commerce',
            'owner_name' => 'Operations Team',
            'business_context' => 'Customer messages are processed and answered with AI assistance.',
            'steps' => [
                [
                    'step_order' => 1,
                    'name' => 'Customer sends support request',
                    'step_type' => StepType::USER_INPUT,
                    'description' => 'Customer sends a message through WhatsApp.',
                    'input_data' => ['message', 'phone_number'],
                    'output_data' => ['support_ticket'],
                    'systems_involved' => ['WhatsApp', 'CRM'],
                    'uses_ai' => false,
                    'uses_personal_data' => true,
                    'has_human_review' => true,
                ],
                [
                    'step_order' => 2,
                    'name' => 'AI drafts response',
                    'step_type' => StepType::AI_PROCESSING,
                    'description' => 'AI generates a draft answer.',
                    'input_data' => ['support_ticket'],
                    'output_data' => ['draft_response'],
                    'systems_involved' => ['LLM Provider'],
                    'uses_ai' => true,
                    'uses_personal_data' => true,
                    'uses_external_api' => true,
                    'has_human_review' => false,
                    'has_audit_log' => false,
                    'has_fallback_path' => false,
                ],
            ],
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('workflows', [
            'title' => 'AI Customer Support Workflow',
        ]);

        $this->assertDatabaseCount('workflow_steps', 2);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'created',
            'entity_type' => Workflow::class,
        ]);
    }

    public function test_it_validates_required_workflow_title(): void
    {
        $response = $this->postJson('/api/v1/workflows', [
            'industry' => 'E-commerce',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);
    }

    public function test_it_can_update_a_workflow_and_write_audit_log(): void
    {
        $workflow = Workflow::create([
            'title' => 'Old Workflow',
            'industry' => 'Retail',
        ]);

        $response = $this->putJson("/api/v1/workflows/{$workflow->id}", [
            'title' => 'Updated Workflow',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('workflows', [
            'id' => $workflow->id,
            'title' => 'Updated Workflow',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'workflow_id' => $workflow->id,
            'action' => 'updated',
            'entity_type' => Workflow::class,
            'entity_id' => $workflow->id,
        ]);
    }
}