<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactusResource extends JsonResource
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
            'location_image' => $this->location_image,
            'location_link' => $this->location_link,
            'face_to_face' => $this->face_to_face,
            'link_way' => $this->link_way,
            'email' => $this->email,
            'telegram' => $this->telegram,
            'instagram' => $this->instagram,
            'whatsapp' => $this->whatsapp,
            'eitaa' => $this->eitaa,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
