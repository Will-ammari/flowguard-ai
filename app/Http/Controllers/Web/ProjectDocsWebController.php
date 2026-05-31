<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class ProjectDocsWebController extends Controller
{
    public function index()
    {
        return view('project_docs.index');
    }
}