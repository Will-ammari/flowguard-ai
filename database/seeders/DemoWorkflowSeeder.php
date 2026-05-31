<?php

namespace Database\Seeders;

use App\Services\Demo\DemoWorkflowBuilder;
use Illuminate\Database\Seeder;

class DemoWorkflowSeeder extends Seeder
{
    public function run(): void
    {
        app(DemoWorkflowBuilder::class)->rebuild();
    }
}