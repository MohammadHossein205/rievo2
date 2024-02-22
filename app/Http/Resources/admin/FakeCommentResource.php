<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FakeCommentResource extends JsonResource
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
            'namefamily' => $this->namefamily,
            'image' => $this->image,
            'body' => $this->body,
            'status' => $this->status,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
