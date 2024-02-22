<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupCompanyResource extends JsonResource
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
            'group_id' => $this->group->name ?? 'خالی',
            'name' => $this->name,
            'english_name' => $this->english_name,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
