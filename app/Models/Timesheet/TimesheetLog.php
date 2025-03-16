<?php

namespace App\Models\Timesheet;

# models
use App\Models\BaseModel;
use App\Models\User;
use App\Models\Project\Project;

# traits
use Illuminate\Database\Eloquent\Factories\HasFactory;

# eloquent
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimesheetLog extends BaseModel
{
    use HasFactory;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'task_name',
        'date',
        'hours',
    ];


    # relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }


    # search

    /**
     * {@inheritDoc}
     */
    public static function search(null|array $params, ?Builder $query = null): Builder
    {
        return static::filter([

            'project_id'    => fn($q, $id) => $q->where('project_id', $id),

            'assignee_id'   => fn($q, $id) => $q->where('user_id', $id),

            'task_name'     => fn($q, $value) => $q->where('task_name', 'like', "%$value%"),

        ], $params, $query)->orderBy('id', 'DESC');
    }
}
