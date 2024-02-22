<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'ticketgroupe_id' => $this->ticketgroupe_id,
            'user_id' => $this->user_id,
            'image' => $this->user->image,
            'user_name' => $this->user->fullname ?? 'نام و نام خانوادگی ندارد',
            'body' => $this->body,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'created_time' => verta($this->created_at)->format('H:i'),
        ];
    }
}
