<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use App\Models\FullPrice;
use Illuminate\Http\Resources\Json\JsonResource;

class FullPriceResource extends JsonResource
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
            'price' => $this->price,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'created_at_chart' => verta($this->created_at)->format('%d - %m - %Y'),
            'updated_at' => verta($this->updated_at)->formatDifference(),
        ];
    }
}
