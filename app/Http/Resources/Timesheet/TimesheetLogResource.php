<?php

namespace App\Http\Resources\Timesheet;

use App\Http\Resources\Project\ProjectAssigneeResource;
use App\Http\Resources\Project\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimesheetLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'task_name' => $this->task_name,
            'project_id'=> $this->project_id,
            'user_id'   => $this->user_id,
            'project'   => ProjectResource::make($this->whenLoaded('project')),
            'user'      => ProjectAssigneeResource::make($this->whenLoaded('user')),
            'date'      => $this->date,
            'hours'     => $this->hours,
            'created_at'=> $this->created_at,
        ];
    }
}
