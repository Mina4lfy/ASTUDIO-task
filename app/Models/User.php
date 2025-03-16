<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

# models
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Project\Project;
use App\Models\Timesheet\TimesheetLog;

# relationships
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

# traits
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

# facades
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->first_name)
            ->explode(' ')
            ->map(fn(string $first_name) => Str::of($first_name)->substr(0, 1))
            ->implode('');
    }


    # appends

    /**
     * {@inheritDoc}
     */
    protected $appends = [
        'name',
    ];

    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }


    # relationships

    /**
     * Timesheet logs added by the current user
     *
     * @return HasMany<TimesheetLog, User>
     */
    public function timesheetLogs(): HasMany
    {
        return $this->hasMany(TimesheetLog::class);
    }

    /**
     * Assigned projects
     *
     * @return BelongsToMany<Project, User>
     */
    public function assignedProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
