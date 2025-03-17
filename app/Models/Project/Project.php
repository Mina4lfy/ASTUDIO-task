<?php

namespace App\Models\Project;

# models
use App\Models\BaseModel;
use App\Models\User;
use App\Models\Project\ProjectUser;
use App\Models\Timesheet\TimesheetLog;

# traits
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Attributable;

# eloquent.
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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


    # search

    /**
     * {@inheritDoc}
     */
    public static function search(null|array $params, ?Builder $query = null): Builder
    {
        return static::filter([

            'name'          => fn($q, $value, $operator) => $q->where('name', $operator, $value),

            'status'        => fn($q, $value, $operator) => $q->where('status', $operator, $value),

            # Filter by department name or id.
            'department'    => fn($q, $value, $operator) => is_numeric($value)
                ? $q->whereHas('department', fn ($subQ) => $subQ->where('content', $operator, $value))
                : $q->whereHas('department', fn ($subQ) => $subQ->whereHas('option', fn ($subSubQ) => $subSubQ->where('content', $operator, $value))),

            'start_date'    => fn($q, $value, $operator) => $q->whereHas('start_date', fn($subQ) => $subQ->where('content', $operator, $value)),

            'end_date'      => fn($q, $value, $operator) => $q->whereHas('end_date', fn($subQ) => $subQ->where('content', $operator, $value)),

        ], $params, $query)->orderBy('id', 'DESC');
    }


    # methods

    /**
     * Assign user(s) to project if not already assigned.
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

    /**
     * Check if project has a specific assignee.
     *
     * @param int|Project $project
     * @return bool
     */
    public function hasAssignee(int|User $user): bool
    {
        return is_numeric($user)
            ? !!$this->assignees()->find($user)
            : $user->isAssignedToProject($this->id);
    }
}
