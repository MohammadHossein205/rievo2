<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentRsource extends JsonResource
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
            'user_id' => $this->user->fullname ?? 'ندارد',
            'payment_type' => $this->payment_type,
            'resNumber' => $this->resNumber,
            'discount' => $this->discount,
            'discount_price' => $this->discount_price,
            'price' => number_format($this->price, '0', '.', ','),
            'card_number' => $this->card_number != 0 ? $this->card_number : 'ندارد',
            'status' => $this->status,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'created_at_with_time' => verta($this->created_at)->format('H:m:s : %d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
