<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Demo\DemoWorkflowBuilder;

class DemoWorkflowController extends Controller
{
    public function rebuild(DemoWorkflowBuilder $demoWorkflowBuilder)
    {
        $demoWorkflowBuilder->rebuild();

        return redirect()
            ->route('case-study.show')
            ->with('success', 'Demo case study workflows were rebuilt and analyzed successfully.');
    }
}