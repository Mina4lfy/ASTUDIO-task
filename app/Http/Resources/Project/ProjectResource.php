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
        return array_merge([
            'id'                => $this->id,
            'name'              => $this->name,
            'status'            => $this->status,
            
        # Get dynamic attributes,
        ], $this->getDynamicAttributes(), [

            'assignees'         => ProjectAssigneeResource::collection($this->whenLoaded('assignees')),
            'assignees_count'   => $this->whenCounted('assignees'),
        ]);
    }
}
