<?php

namespace App\Http\Resources\home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleTicketResource extends JsonResource
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
            'user_id' => $this->user_id,
            'image' => $this->user->image,
            'body' => $this->body,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'created_time' => verta($this->created_at)->format('H:i'),
        ];
    }
}
