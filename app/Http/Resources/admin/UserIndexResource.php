<?php

namespace App\Http\Resources\admin;

use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserIndexResource extends JsonResource
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
            'username' => $this->username,
            'discount_id' => $this->discountcodes,
            'fullname' => $this->fullname,
            'image' => $this->image,
            'nationalCode' => $this->nationalCode,
            'mobile' => $this->mobile,
            'homeNumber' => $this->homeNumber,
            'birthDate' => $this->birthDate,
            'email' => $this->email,
            'address' => $this->address,
            'role' => $this->getRoleNames(),
            'dam_count' => $this->dams->count(),
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
