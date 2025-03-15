<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\Request as BaseRequest;

class ProjectRequest extends BaseRequest
{
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'status' => [
                'required',
                'string',
                'max:255',
            ],
            'department' => [
                'required',
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
