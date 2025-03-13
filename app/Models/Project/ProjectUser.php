<?php

namespace App\Models\Project;

# models
use App\Models\BaseModel;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectUser extends BaseModel
{
    use HasFactory;

    /**
     * {@inheritDoc}
     */
    protected $table = 'project_user';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'project_id',
        'user_id',
    ];


    # relationships

    /**
     * Relationship to project that user is assigned to
     *
     * @return BelongsTo<Project, ProjectUser>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relationship to assigned user to project
     *
     * @return BelongsTo<User, ProjectUser>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
