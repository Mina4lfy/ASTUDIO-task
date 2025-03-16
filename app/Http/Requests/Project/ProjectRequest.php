<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\Request as BaseRequest;
use App\Models\Project\Project;
use App\Enum\ProjectStatus;

class ProjectRequest extends BaseRequest
{
    /**
     * Timesheet log from bound params.
     *
     * @var null|Project
     */
    protected null|project $project;

    /**
     * {@inheritDoc}
     */
    public function prepareForValidation(): void
    {
        $this->project = $this->route('project');
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        $requiredOnCreate = $this->project ? 'nullable' : 'required';

        return [
            'name' => [
                $requiredOnCreate,
                'string',
                'max:255'
            ],
            'status' => [
                $requiredOnCreate,
                'string',
                'max:255',
                ProjectStatus::validationRule(),
            ],
            'department' => [
                $requiredOnCreate,
                'numeric',
                'exists:' . config('rinvex.attributes.tables.attributes_options') . ',id',
            ],
            'start_date' => [
                'nullable',
                'date',
            ],
            'end_date' => [
                'nullable',
                'date',
            ],
        ];
    }
}
