<?php

namespace App\Models\Project;

# models
use App\Models\BaseModel;
use App\Models\User;
use App\Models\Project\ProjectUser;
use App\Models\Timesheet\TimesheetLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use \Rinvex\Attributes\Traits\Attributable;

class Project extends BaseModel
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory, Attributable;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * {@inheritDoc}
     */
    protected $with = [
        'eav',
    ];


    # relationships

    /**
     * Relationship to project assignees (users)
     *
     * @return HasManyThrough<User, ProjectUser, Project>
     */
    public function assignees(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, ProjectUser::class, 'project_id', 'id', 'id', 'user_id');
    }

    /**
     * Relationship to timesheet logs
     *
     * @return HasMany<TimesheetLog, Project>
     */
    public function timesheetLogs(): HasMany
    {
        return $this->hasMany(TimesheetLog::class);
    }


    # methods

    /**
     * Assign user(s) to project if not already assigned
     *
     * @param array<\App\Models\User> $users
     * @return bool
     */
    public function assign(...$users): bool
    {
        $projectAssignees = collect($users)->map(fn(User $user) => [
            'project_id' => $this->id,
            'user_id' => $user->id,
        ])->toArray();

        return !!ProjectUser::upsert($projectAssignees, ['project_id', 'user_id']);
    }
}
