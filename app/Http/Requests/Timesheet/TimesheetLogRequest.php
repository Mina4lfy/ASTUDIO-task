<?php

namespace App\Http\Requests\Timesheet;

use App\Http\Requests\Request as BaseRequest;
use App\Models\Timesheet\TimesheetLog;

class TimesheetLogRequest extends BaseRequest
{
    /**
     * Timesheet log from bound params.
     *
     * @var null|TimesheetLog
     */
    protected null|TimesheetLog $timesheetLog;

    /**
     * Only allow admins and project assignees.
     *
     * Logged-in users can log to their own timesheets.
     * Users can only update their own timesheets.
     *
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        /** @var \App\Models\User $user */
        $user = $this->user();

        $this->timesheetLog = $this->route('timesheetLog');

        return ($this->timesheetLog = $this->route('timesheetLog'))
            ? $this->timesheetLog->user_id === $user->id // Updating an existing timesheet log.
            : !$this->project_id || $user->isAssignedToProject($this->project_id); // Creating a new timesheet log.
    }

    /**
     * {@inheritDoc}
     */
    public function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->merge(['user_id' => $this->user()?->id]);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        $requiredOnCreate = $this->timesheetLog ? 'nullable' : 'required';

        return [
            'user_id' => [
                'required',
                'numeric',
                'exists:users,id',
            ],
            'project_id' => [
                $requiredOnCreate,
                'numeric',
                'exists:projects,id',
            ],
            'task_name' => [
                $requiredOnCreate,
                'string',
                'max:255',
            ],
            'date' => [
                $requiredOnCreate,
                'date',
            ],
            'hours' => [
                $requiredOnCreate,
                'numeric',
                'min:1',
            ],
        ];
    }
}
