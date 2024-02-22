<?php

namespace App\Http\Resources\admin;

use App\Models\Dam;
use App\Models\Damvizhe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDetailResource extends JsonResource
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
            'payment_id' => $this->payment_id,
            'paymentable_id' => $this->paymentable_type == strval(Dam::class) ? Dam::where('id', $this->paymentable_id)->get('name')[0]["name"] : Damvizhe::where('id', $this->paymentable_id)->get('name')[0]["name"],
//            'paymentable_id' => $this->paymentable_id,
            'paymentable_id_org' => $this->paymentable_id,
            'paymentable_type' => $this->paymentable_type,
            'description' => $this->description,
            'count' => $this->count,
            'price' => $this->paymentable_type == strval(Dam::class) ? number_format(Dam::where('id', $this->paymentable_id)->get('price')[0]["price"], '0', '.', '.') : number_format(Damvizhe::where('id', $this->paymentable_id)->get('price')[0]["price"], '0', '.', '.'),
//            'price' => $this->paymentable_id,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
