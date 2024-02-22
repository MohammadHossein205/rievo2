<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountCodeResource extends JsonResource
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
            'discount_code' => $this->discount_code,
            'price' => number_format($this->price, 0, '.', '.'),
            'count' => $this->count,
            'end_time' => verta($this->end_time)->format('%d %B %Y'),
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
