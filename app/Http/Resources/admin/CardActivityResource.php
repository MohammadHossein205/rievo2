<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardActivityResource extends JsonResource
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
            'payment_type' => $this->payment_type,
            'price' => number_format($this->price, 0, '.', ','),
            'wage' => number_format($this->wage, 0, '.', ','),
            'card_number' => $this->card_number,
            'res_number' => $this->res_number,
            'status' => $this->status,
            'created_at' => verta($this->created_at)->format('%d %B %Y ، %H:%m'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
