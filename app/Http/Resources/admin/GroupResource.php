<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'dam_count' => $this->dams->where('status', 1)->count(),
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
            'updated_at_chart' => verta($this->updated_at)->format('%d - %m - %Y'),
        ];
    }
}
