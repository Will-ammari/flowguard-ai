<?php

namespace App\Services\Demo;

use App\Enums\StepType;
use App\Models\Workflow;
use App\Services\Risk\RiskAnalyzer;
use Illuminate\Support\Collection;

class DemoWorkflowBuilder
{
    const BEFORE_TITLE = 'Demo - Uncontrolled AI WhatsApp Support';
    const AFTER_TITLE = 'Demo - Controlled AI WhatsApp Support';

    private $riskAnalyzer;

    public function __construct(RiskAnalyzer $riskAnalyzer)
    {
        $this->riskAnalyzer = $riskAnalyzer;
    }

    public function rebuild(): Collection
    {
        $before = $this->buildBeforeWorkflow();
        $after = $this->buildAfterWorkflow();

        $this->riskAnalyzer->analyze($before->fresh('steps'));
        $this->riskAnalyzer->analyze($after->fresh('steps'));

        return collect([
            $before->fresh(['steps', 'riskFindings', 'reports']),
            $after->fresh(['steps', 'riskFindings', 'reports']),
        ]);
    }

    public function getDemoWorkflows(): Collection
    {
        return Workflow::whereIn('title', [self::BEFORE_TITLE, self::AFTER_TITLE])
            ->with(['steps', 'riskFindings.workflowStep', 'reports'])
            ->get()
            ->sortBy(function (Workflow $workflow) {
                return $workflow->title === self::BEFORE_TITLE ? 1 : 2;
            })
            ->values();
    }

    private function buildBeforeWorkflow(): Workflow
    {
        $workflow = $this->resetWorkflow(self::BEFORE_TITLE, [
            'description' => 'A deliberately risky baseline workflow where an LLM drafts and sends customer replies with limited controls.',
            'industry' => 'Customer Support Automation',
            'owner_name' => 'Demo Baseline Team',
            'business_context' => 'This baseline scenario demonstrates how missing human review, logging, and fallback controls increase operational and governance risk.',
        ]);

        $workflow->steps()->createMany([
            [
                'step_order' => 1,
                'name' => 'Customer sends WhatsApp message',
                'step_type' => StepType::USER_INPUT,
                'description' => 'Customer sends a free-text support message to the business.',
                'input_data' => [],
                'output_data' => ['customer_message', 'phone_number'],
                'systems_involved' => ['WhatsApp Business API'],
                'uses_ai' => false,
                'uses_personal_data' => true,
                'has_human_review' => false,
                'is_customer_facing' => true,
                'uses_external_api' => true,
                'stores_data' => false,
                'uses_sensitive_data' => false,
                'has_audit_log' => false,
                'has_fallback_path' => false,
                'is_irreversible_action' => false,
            ],
            [
                'step_order' => 2,
                'name' => 'n8n forwards message to LLM',
                'step_type' => StepType::AI_PROCESSING,
                'description' => 'The automation sends the full customer message and phone number to an LLM provider.',
                'input_data' => ['customer_message', 'phone_number'],
                'output_data' => ['ai_generated_reply'],
                'systems_involved' => ['n8n', 'LLM Provider'],
                'uses_ai' => true,
                'uses_personal_data' => true,
                'has_human_review' => false,
                'is_customer_facing' => true,
                'uses_external_api' => true,
                'stores_data' => false,
                'uses_sensitive_data' => false,
                'has_audit_log' => false,
                'has_fallback_path' => false,
                'is_irreversible_action' => false,
            ],
            [
                'step_order' => 3,
                'name' => 'AI reply is sent directly to customer',
                'step_type' => StepType::MESSAGE_SENDING,
                'description' => 'The generated reply is sent automatically without review, approval, or escalation.',
                'input_data' => ['ai_generated_reply', 'phone_number'],
                'output_data' => ['sent_message_id'],
                'systems_involved' => ['WhatsApp Business API'],
                'uses_ai' => true,
                'uses_personal_data' => true,
                'has_human_review' => false,
                'is_customer_facing' => true,
                'uses_external_api' => true,
                'stores_data' => false,
                'uses_sensitive_data' => false,
                'has_audit_log' => false,
                'has_fallback_path' => false,
                'is_irreversible_action' => true,
            ],
        ]);

        return $workflow;
    }

    private function buildAfterWorkflow(): Workflow
    {
        $workflow = $this->resetWorkflow(self::AFTER_TITLE, [
            'description' => 'An improved workflow that keeps AI assistance but adds data minimization, human approval, audit logging, and fallback controls.',
            'industry' => 'Customer Support Automation',
            'owner_name' => 'Demo Improved Team',
            'business_context' => 'This improved scenario demonstrates how engineering controls reduce risk while preserving the operational value of AI-assisted support.',
        ]);

        $workflow->steps()->createMany([
            [
                'step_order' => 1,
                'name' => 'Customer sends WhatsApp message',
                'step_type' => StepType::USER_INPUT,
                'description' => 'Customer sends a support message to the business through WhatsApp.',
                'input_data' => [],
                'output_data' => ['customer_message', 'phone_number'],
                'systems_involved' => ['WhatsApp Business API'],
                'uses_ai' => false,
                'uses_personal_data' => true,
                'has_human_review' => false,
                'is_customer_facing' => true,
                'uses_external_api' => true,
                'stores_data' => false,
                'uses_sensitive_data' => false,
                'has_audit_log' => true,
                'has_fallback_path' => true,
                'is_irreversible_action' => false,
            ],
            [
                'step_order' => 2,
                'name' => 'Backend minimizes message payload',
                'step_type' => StepType::FILE_PROCESSING,
                'description' => 'The backend removes unnecessary identifiers and prepares a minimized prompt payload.',
                'input_data' => ['customer_message', 'phone_number'],
                'output_data' => ['redacted_customer_message'],
                'systems_involved' => ['FlowGuard Demo Backend'],
                'uses_ai' => false,
                'uses_personal_data' => true,
                'has_human_review' => false,
                'is_customer_facing' => false,
                'uses_external_api' => false,
                'stores_data' => true,
                'uses_sensitive_data' => false,
                'has_audit_log' => true,
                'has_fallback_path' => true,
                'is_irreversible_action' => false,
            ],
            [
                'step_order' => 3,
                'name' => 'LLM generates suggested reply',
                'step_type' => StepType::AI_PROCESSING,
                'description' => 'The LLM receives a minimized message and drafts an internal reply suggestion.',
                'input_data' => ['redacted_customer_message', 'support_policy'],
                'output_data' => ['suggested_reply'],
                'systems_involved' => ['LLM Provider'],
                'uses_ai' => true,
                'uses_personal_data' => true,
                'has_human_review' => false,
                'is_customer_facing' => false,
                'uses_external_api' => true,
                'stores_data' => false,
                'uses_sensitive_data' => false,
                'has_audit_log' => true,
                'has_fallback_path' => true,
                'is_irreversible_action' => false,
            ],
            [
                'step_order' => 4,
                'name' => 'Human agent approves reply',
                'step_type' => StepType::HUMAN_REVIEW,
                'description' => 'A support agent reviews, edits, approves, or rejects the suggested reply.',
                'input_data' => ['suggested_reply'],
                'output_data' => ['approved_reply'],
                'systems_involved' => ['Support Dashboard'],
                'uses_ai' => false,
                'uses_personal_data' => true,
                'has_human_review' => true,
                'is_customer_facing' => false,
                'uses_external_api' => false,
                'stores_data' => true,
                'uses_sensitive_data' => false,
                'has_audit_log' => true,
                'has_fallback_path' => true,
                'is_irreversible_action' => false,
            ],
            [
                'step_order' => 5,
                'name' => 'Approved reply is sent to customer',
                'step_type' => StepType::MESSAGE_SENDING,
                'description' => 'Only the approved reply is sent to the customer through WhatsApp.',
                'input_data' => ['approved_reply', 'phone_number'],
                'output_data' => ['sent_message_id'],
                'systems_involved' => ['WhatsApp Business API'],
                'uses_ai' => false,
                'uses_personal_data' => true,
                'has_human_review' => true,
                'is_customer_facing' => true,
                'uses_external_api' => true,
                'stores_data' => false,
                'uses_sensitive_data' => false,
                'has_audit_log' => true,
                'has_fallback_path' => true,
                'is_irreversible_action' => true,
            ],
        ]);

        return $workflow;
    }

    private function resetWorkflow($title, array $attributes): Workflow
    {
        $workflow = Workflow::updateOrCreate(['title' => $title], $attributes);

        $workflow->riskFindings()->delete();
        $workflow->reports()->delete();
        $workflow->steps()->delete();

        return $workflow->fresh();
    }
}