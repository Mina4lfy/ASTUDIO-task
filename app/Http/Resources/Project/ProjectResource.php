<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class ProjectResource extends BaseResource
{
    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'status'            => $this->status,
            'assignees'         => ProjectAssigneeResource::collection($this->whenLoaded('assignees')),
            'assignees_count'   => $this->whenCounted('assignees'),
            'department'        => $this->department,
            'start_date'        => $this->start_date,
            'end_date'          => $this->end_date,
        ];
    }
}
