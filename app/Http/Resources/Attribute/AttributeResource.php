<?php

namespace App\Http\Resources\Attribute;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'type'          => $this->type,
            'description'   => $this->description,
            'sort_order'    => $this->sort_order,
            'updated_at'    => $this->updated_at,
            'created_at'    => $this->created_at,
            'entities'      => $this->entities,
        ];
    }
}
