<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RiskFinding;
use App\Models\Workflow;
use App\Models\WorkflowStep;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'workflowsCount' => Workflow::count(),
            'stepsCount' => WorkflowStep::count(),
            'findingsCount' => RiskFinding::count(),
            'latestWorkflows' => Workflow::latest()->take(5)->get(),
        ]);
    }
}