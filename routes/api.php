<?php

use App\Http\Controllers\Api\RiskAnalysisController;
use App\Http\Controllers\Api\WorkflowAuditLogController;
use App\Http\Controllers\Api\WorkflowController;
use App\Http\Controllers\Api\WorkflowStepController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.')->group(function (): void {
    Route::apiResource('workflows', WorkflowController::class);

    Route::post('workflows/{workflow}/steps', [WorkflowStepController::class, 'store'])
        ->name('workflows.steps.store');

    Route::put('workflow-steps/{workflowStep}', [WorkflowStepController::class, 'update'])
        ->name('workflow-steps.update');

    Route::delete('workflow-steps/{workflowStep}', [WorkflowStepController::class, 'destroy'])
        ->name('workflow-steps.destroy');

    Route::post('workflows/{workflow}/analyze', [RiskAnalysisController::class, 'analyze'])
        ->name('workflows.analyze');

    Route::get('workflows/{workflow}/findings', [RiskAnalysisController::class, 'findings'])
        ->name('workflows.findings');

    Route::get('workflows/{workflow}/audit-logs', [WorkflowAuditLogController::class, 'index'])
        ->name('workflows.audit-logs.index');
});