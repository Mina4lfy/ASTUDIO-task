<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project\Project;
use App\Models\Timesheet\TimesheetLog;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Count of users to seed
     *
     * @const int
     */
    private const USERS_COUNT = 10;

    /**
     * Count of projects to seed
     *
     * @const int
     */
    private const PROJECTS_COUNT = 10;

    /**
     * Count of timesheet logs to seed
     *
     * @const int
     */
    private const TIMESHEET_LOGS_COUNT = 100;

    /**
     * Departments to use when seeding projects. (text attribute)
     *
     * @const array
     */
    private const PROJECT_DEPARTMENTS = ['Software Development (1)', 'Marketing (2)', 'Security (3)'];


    # Runer

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = $this->seedUsers();

        $this->seedAttributes();
        $projects = $this->seedProjects();
        $this->seedProjectAttributes($projects);

        $this->seedProjectAssignees($users, $projects);

        $this->seedTimesheetLogs();

        echo "✓ Database seeded successfully.\r\n\r\n";
    }


    # Seeders

    /**
     * Seed users.
     *
     * @return \Illuminate\Support\Collection
     */
    private function seedUsers(): Collection
    {
        $user = User::factory()->create([
            'first_name' => 'Mina',
            'last_name' => 'Alfy',
            'email' => 'minaalfy8@gmail.com',
            'password' => bcrypt('newPassw&rd1'),
        ]);

        return collect([$user])->merge(User::factory(static::USERS_COUNT - 1)->create());
    }

    /**
     * Seed projects.
     *
     * @return \Illuminate\Support\Collection
     */
    private function seedProjects(): Collection
    {
        return Project::factory(static::PROJECTS_COUNT)->create();
    }

    /**
     * Seed attributes. (department, start_date, end_date)
     *
     * @param \Illuminate\Support\Collection $projects
     * @return \Illuminate\Support\Collection
     */
    private function seedAttributes(): Collection
    {
        $attributes[] = $departmentAttribute = app('rinvex.attributes.attribute')->updateOrCreate([
            'slug' => 'department',
        ], [
            'description' => 'Department that project belongs to.',
            'type' => 'select',
            'name' => 'Department',
            'is_required' => true,
            'entities' => [Project::class],
        ]);

        # Add department options.
        $departmentAttribute->addOptions(static::PROJECT_DEPARTMENTS);

        $attributes[] = app('rinvex.attributes.attribute')->updateOrCreate([
            'slug' => 'start_date',
        ], [
            'description' => 'Project start date.',
            'type' => 'date',
            'name' => 'Start date',
            'entities' => [Project::class],
        ]);

        $attributes[] = app('rinvex.attributes.attribute')->updateOrCreate([
            'slug' => 'end_date',
        ], [
            'description' => 'Project end date.',
            'type' => 'date',
            'name' => 'End date',
            'entities' => [Project::class],
        ]);

        return collect($attributes);
    }

    /**
     * Seed project attributes
     *
     * @param \Illuminate\Support\Collection $projects
     * @return \Illuminate\Support\Collection|void
     */
    private function seedProjectAttributes(Collection $projects)
    {
        foreach ($projects as $project) {
            $project
                ->setAttribute('department', rand(1, count(static::PROJECT_DEPARTMENTS)))
                ->setAttribute('start_date', fake()->date())
                ->setAttribute('end_date', fake()->date())
                ->save();
        }
    }

    /**
     * Seed project assignees.
     *
     * @param \Illuminate\Support\Collection $users
     * @param \Illuminate\Support\Collection $projects
     * @return void
     */
    private function seedProjectAssignees(Collection $users, Collection $projects)
    {
        # Assign random users to each project.
        foreach ($projects as $project) {
            $project->assign(...$users->random(rand(1, static::USERS_COUNT)));
        }
    }

    /**
     * Seed timesheet logs.
     *
     * @return \Illuminate\Support\Collection
     */
    private function seedTimesheetLogs(): Collection
    {
        return TimesheetLog::factory(static::TIMESHEET_LOGS_COUNT)->create();
    }
}
