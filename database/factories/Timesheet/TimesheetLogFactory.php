<?php

namespace Database\Factories\Timesheet;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet\TimesheetLog>
 */
class TimesheetLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $project = Project::inRandomOrder()->first();

        return [
            'project_id' => $project->id,
            'user_id' => $project->assignees()->inRandomOrder()->first()->id,
            'task_name' => fake()->paragraph(2),
            'hours' => fake()->numberBetween(1, 100),
            'date' => fake()->date(),
        ];
    }
}
