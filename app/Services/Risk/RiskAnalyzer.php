<?php

namespace App\Services\Risk;

use App\Domain\Risk\DTO\RiskFindingData;
use App\Domain\Risk\RiskRuleRegistry;
use App\Enums\RiskLevel;
use App\Models\RiskFinding;
use App\Models\Workflow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class RiskAnalyzer
{
    private $registry;

    public function __construct(RiskRuleRegistry $registry = null)
    {
        $this->registry = $registry ?: new RiskRuleRegistry();
    }

    public function analyze(Workflow $workflow): array
    {
        $workflow->load('steps');

        return DB::transaction(function () use ($workflow) {
            $workflow->riskFindings()->delete();

            $findingData = $this->collectFindingData($workflow);
            $overallRisk = $this->calculateOverallRisk($findingData);

            $findings = $findingData->map(function (RiskFindingData $data) use ($workflow) {
                return $this->persistFinding($workflow, $data);
            });

            $reportPayload = $this->buildReportPayload($workflow, $overallRisk, $findings);

            $report = $workflow->reports()->create([
                'overall_risk_level' => $overallRisk,
                'summary' => $this->buildSummary($workflow, $overallRisk, $findings, $reportPayload),
                'report_payload' => $reportPayload,
            ]);

            return [
                'overall_risk_level' => $overallRisk,
                'findings' => $findings,
                'report' => $report,
            ];
        });
    }

    private function collectFindingData(Workflow $workflow): Collection
    {
        $steps = $workflow->steps;

        return collect($this->registry->rules())
            ->flatMap(function ($rule) use ($workflow, $steps) {
                return $rule->evaluate($workflow, $steps);
            })
            ->unique(function (RiskFindingData $finding) {
                return $finding->code.'-'.$finding->workflowStepId;
            })
            ->sortByDesc(function (RiskFindingData $finding) {
                return $finding->score;
            })
            ->values();
    }

    private function persistFinding(Workflow $workflow, RiskFindingData $data): RiskFinding
    {
        return RiskFinding::create([
            'workflow_id' => $workflow->id,
            'workflow_step_id' => $data->workflowStepId,
            'risk_code' => $data->code,
            'risk_title' => $data->title,
            'risk_level' => $data->level,
            'risk_category' => $data->category,
            'risk_score' => $data->score,
            'control_status' => $data->controlStatus,
            'description' => $data->description,
            'recommendation' => $data->recommendation,
            'engineering_control' => $data->engineeringControl,
            'metadata' => $data->metadata,
        ]);
    }

    private function calculateOverallRisk(Collection $findings): string
    {
        if ($findings->isEmpty()) {
            return RiskLevel::NONE;
        }

        $maxScore = (int) $findings->max('score');
        $highCount = $findings->filter(function (RiskFindingData $finding) {
            return $finding->level === RiskLevel::HIGH || $finding->level === RiskLevel::CRITICAL;
        })->count();

        if ($maxScore >= 9) {
            return RiskLevel::CRITICAL;
        }

        if ($maxScore >= 8 || $highCount >= 2) {
            return RiskLevel::HIGH;
        }

        if ($maxScore >= 5) {
            return RiskLevel::MEDIUM;
        }

        return RiskLevel::LOW;
    }

    private function buildReportPayload(Workflow $workflow, $overallRisk, Collection $findings): array
    {
        $findingsByLevel = $findings->groupBy(function (RiskFinding $finding) {
            return $finding->risk_level;
        })->map(function ($group) {
            return $group->count();
        });

        $findingsByCategory = $findings->groupBy(function (RiskFinding $finding) {
            return $finding->risk_category;
        })->map(function ($group) {
            return $group->count();
        });

        $findingsByControlStatus = $findings->groupBy(function (RiskFinding $finding) {
            return $finding->control_status;
        })->map(function ($group) {
            return $group->count();
        });

        return [
            'workflow' => [
                'id' => $workflow->id,
                'title' => $workflow->title,
                'industry' => $workflow->industry,
            ],
            'overall_risk_level' => $overallRisk,
            'findings_count' => $findings->count(),
            'max_risk_score' => $findings->max('risk_score') ?: 0,
            'average_risk_score' => $findings->count() > 0 ? round($findings->avg('risk_score'), 2) : 0,
            'findings_by_level' => $findingsByLevel,
            'findings_by_category' => $findingsByCategory,
            'findings_by_control_status' => $findingsByControlStatus,
        ];
    }

    private function buildSummary(Workflow $workflow, $overallRisk, Collection $findings, array $payload): string
    {
        $dominantCategory = 'general engineering controls';

        if (!empty($payload['findings_by_category']) && count($payload['findings_by_category']) > 0) {
            $categories = collect($payload['findings_by_category'])->sortDesc();
            $dominantCategory = $categories->keys()->first() ?: $dominantCategory;
        }

        return sprintf(
            'Workflow "%s" was analyzed with an overall risk level of %s, %d finding(s), a maximum risk score of %s/10, and an average risk score of %s/10. The dominant focus area is %s.',
            $workflow->title,
            $overallRisk,
            $findings->count(),
            $payload['max_risk_score'],
            $payload['average_risk_score'],
            $dominantCategory
        );
    }
}
