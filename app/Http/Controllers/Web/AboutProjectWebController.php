<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RiskFinding;
use App\Models\Workflow;
use App\Models\WorkflowStep;

class AboutProjectWebController extends Controller
{
    public function show()
    {
        return view('about_project.show', [
            'workflowsCount' => Workflow::count(),
            'stepsCount' => WorkflowStep::count(),
            'findingsCount' => RiskFinding::count(),
        ]);
    }
}