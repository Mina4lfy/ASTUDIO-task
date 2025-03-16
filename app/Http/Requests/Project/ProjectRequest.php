<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\Request as BaseRequest;
use App\Models\Project\Project;
use App\Models\EAV\Type\Common\Option;

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

        # Cast status: `attributes_options.content` to `attributes_options.id`.
        $this->merge([
            'status_name' => $status = $this->status,
            'status' => $status ? Option::where('content', $status)->first()?->id ?? -1 : -1,
        ]);
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
                'max:255',
            ],
            'status' => [
                $requiredOnCreate,
                'numeric',
                'exists:' . config('rinvex.attributes.tables.attributes_options') . ',id',
            ],
            'department' => [
                $requiredOnCreate,
                'string',
                'max:255',
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
