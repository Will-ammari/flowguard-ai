<?php

namespace Tests\Feature;

use App\Services\Demo\DemoWorkflowBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioCaseStudyTest extends TestCase
{
    use RefreshDatabase;

    public function test_case_study_page_loads_without_demo_data(): void
    {
        $response = $this->get('/case-study');

        $response->assertOk();
        $response->assertSee('Portfolio Case Study');
        $response->assertSee('No demo case study data yet');
    }

    public function test_demo_case_study_can_be_built(): void
    {
        $response = $this->post('/demo-workflows/rebuild');

        $response->assertRedirect('/case-study');

        $this->assertDatabaseHas('workflows', [
            'title' => DemoWorkflowBuilder::BEFORE_TITLE,
        ]);

        $this->assertDatabaseHas('workflows', [
            'title' => DemoWorkflowBuilder::AFTER_TITLE,
        ]);

        $this->assertDatabaseCount('analysis_reports', 2);
    }

    public function test_case_study_page_shows_comparison_after_demo_build(): void
    {
        $this->post('/demo-workflows/rebuild');

        $response = $this->get('/case-study');

        $response->assertOk();
        $response->assertSee('Baseline Risk');
        $response->assertSee('Improved Risk');
        $response->assertSee('Finding Change');
        $response->assertSee('Max Score Change');
    }
}