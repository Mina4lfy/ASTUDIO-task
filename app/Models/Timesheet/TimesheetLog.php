<?php

namespace App\Models\Timesheet;

# models
use App\Models\BaseModel;
use App\Models\User;
use App\Models\Project\Project;

# traits
use Illuminate\Database\Eloquent\Factories\HasFactory;

# eloquent.
use Illuminate\Contracts\Database\Query\Builder;
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

            'project_id'    => fn($q, $value, $operator) => $q->where('project_id', $operator, $value),

            'user_id'       => fn($q, $value, $operator) => $q->where('user_id', $operator, $value),

            'task_name'     => fn($q, $value, $operator) => $q->where('task_name', $operator, $value),

            'hours'         => fn($q, $value, $operator) => $q->where('hours', $operator, $value),

            'date'          => fn($q, $value, $operator) => $q->where('date', $operator, $value),

            'created_at'    => fn($q, $value, $operator) => $q->where('created_at', $operator, $value),

        ], $params, $query)->orderBy('id', 'DESC');
    }
}
