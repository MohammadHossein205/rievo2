<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'user_id' => $this->user->fullname,
            'body' => $this->body,
            'is_new' => $this->is_new,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'created_time' => verta($this->created_at)->format('H:i'),
        ];
    }
}
