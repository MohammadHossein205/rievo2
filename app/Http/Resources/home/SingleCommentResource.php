<?php

namespace App\Http\Resources\home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleCommentResource extends JsonResource
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
            'image' => $this->user->image,
            'body' => $this->body,
//            'commentable_id' => $this->commentable->name,
//            'commentable_type' => $this->commentable_type,
            'rate' => $this->rate,
//            'status' => $this->status,
//            'is_seen' => $this->is_seen,
            'created_at' => verta($this->created_at)->formatDifference(),
//            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
