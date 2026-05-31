<?php

namespace Database\Factories;

use App\Models\Workflow;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkflowFactory extends Factory
{
    protected $model = Workflow::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'industry' => $this->faker->randomElement(['Customer Support', 'Healthcare Intake', 'E-commerce', 'HR Automation']),
            'owner_name' => $this->faker->company(),
            'business_context' => $this->faker->paragraph(),
        ];
    }
}
