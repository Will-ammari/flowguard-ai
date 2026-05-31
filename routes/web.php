<?php

use App\Http\Controllers\Web\AboutProjectWebController;
use App\Http\Controllers\Web\CaseStudyWebController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DataFlowWebController;
use App\Http\Controllers\Web\DemoWorkflowController;
use App\Http\Controllers\Web\ProjectDocsWebController;
use App\Http\Controllers\Web\ReportWebController;
use App\Http\Controllers\Web\RiskAnalysisWebController;
use App\Http\Controllers\Web\WorkflowStepWebController;
use App\Http\Controllers\Web\WorkflowWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/about-project', [AboutProjectWebController::class, 'show'])
    ->name('about-project.show');

Route::get('/project-docs', [ProjectDocsWebController::class, 'index'])
    ->name('project-docs.index');

Route::get('/case-study', [CaseStudyWebController::class, 'show'])
    ->name('case-study.show');

Route::post('/demo-workflows/rebuild', [DemoWorkflowController::class, 'rebuild'])
    ->name('demo-workflows.rebuild');

Route::get('/workflows', [WorkflowWebController::class, 'index'])
    ->name('workflows.index');

Route::get('/workflows/create', [WorkflowWebController::class, 'create'])
    ->name('workflows.create');

Route::post('/workflows', [WorkflowWebController::class, 'store'])
    ->name('workflows.store');

Route::get('/workflows/{workflow}', [WorkflowWebController::class, 'show'])
    ->name('workflows.show');

Route::get('/workflows/{workflow}/edit', [WorkflowWebController::class, 'edit'])
    ->name('workflows.edit');

Route::put('/workflows/{workflow}', [WorkflowWebController::class, 'update'])
    ->name('workflows.update');

Route::delete('/workflows/{workflow}', [WorkflowWebController::class, 'destroy'])
    ->name('workflows.destroy');

Route::get('/workflows/{workflow}/steps/create', [WorkflowStepWebController::class, 'create'])
    ->name('workflow-steps.create');

Route::post('/workflows/{workflow}/steps', [WorkflowStepWebController::class, 'store'])
    ->name('workflow-steps.store');

Route::get('/workflows/{workflow}/steps/{workflowStep}/edit', [WorkflowStepWebController::class, 'edit'])
    ->name('workflow-steps.edit');

Route::put('/workflows/{workflow}/steps/{workflowStep}', [WorkflowStepWebController::class, 'update'])
    ->name('workflow-steps.update');

Route::delete('/workflows/{workflow}/steps/{workflowStep}', [WorkflowStepWebController::class, 'destroy'])
    ->name('workflow-steps.destroy');

Route::post('/workflows/{workflow}/analyze', [RiskAnalysisWebController::class, 'analyze'])
    ->name('workflows.analyze');

Route::get('/workflows/{workflow}/report', [ReportWebController::class, 'show'])
    ->name('workflows.report');

Route::get('/workflows/{workflow}/data-flow', [DataFlowWebController::class, 'show'])
    ->name('workflows.data-flow');