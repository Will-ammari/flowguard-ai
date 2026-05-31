<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('flowguard:demo', function () {
    $this->call('db:seed', ['--class' => 'DemoWorkflowSeeder']);
    $this->info('Demo workflow seeded.');
})->purpose('Seed the FlowGuard AI demo workflow');
