<?php

namespace App\Models\Project;

# models
use App\Models\BaseModel;
use App\Models\User;
use App\Models\Project\ProjectUser;
use App\Models\Timesheet\TimesheetLog;

# traits
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Rinvex\Attributes\Traits\Attributable;

# eloquent.
use Illuminate\Database\Eloquent\Builder;
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

            'name'          => fn($q, $value) => $q->where('name', 'like', "%$value%"),

            'status'        => fn($q, $value) => $q->where('status', 'like', "%$value%"),

            'department'    => fn($q, $value) => $q->whereHas('department', fn ($subQ) => $subQ->whereHas('option', fn ($subSubQ) => $subSubQ->where('content', 'like', "%$value%"))),

            'start_date'    => fn($q, $value) => $q->whereHas('start_date', fn($subQ) => $subQ->where('content', 'like', "%$value%")),

            'end_date'      => fn($q, $value) => $q->whereHas('end_date', fn($subQ) => $subQ->where('content', 'like', "%$value%")),

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
