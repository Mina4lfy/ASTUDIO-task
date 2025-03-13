<?php

namespace App\Models\Project;

# models
use App\Models\BaseModel;
use App\Models\User;
use App\Models\Project\ProjectUser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends BaseModel
{
    use HasFactory;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'status',
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


    # methods

    /**
     * Assign user to project if not already assigned
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function assign(User $user): bool
    {
        return !!ProjectUser::firstOrCreate([
            'project_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }
}
