<?php

namespace App\Http\Resources\home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportResource extends JsonResource
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
//            'user_id' => $this->user->fullname,
            'title' => $this->title,
            'status' => $this->status,
            'created_at' => verta($this->updated_at)->format('H:i -- %d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('H:i -- %d %B %Y'),
        ];
    }
}
