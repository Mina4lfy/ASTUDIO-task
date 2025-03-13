<?php

namespace App\Models\Timesheet;

# models
use App\Models\BaseModel;
use App\Models\User;
use App\Models\Project\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
