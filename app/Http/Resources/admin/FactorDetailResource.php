<?php

namespace App\Http\Resources\admin;

use App\Models\Dam;
use App\Models\Damvizhe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactorDetailResource extends JsonResource
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
            'factor_id' => $this->factor_id,
            'factortable_id' => $this->GetDamOrDamvizhe($this->factortable_type),
            'factortable_type' => $this->factortable_type,
            'count' => $this->count,
            'monthly_money' => number_format($this->monthly_money, 0, '.', ','),
            'price' => number_format($this->GetDamOrDamvizhePrice($this->factortable_type), 0, '.', ','),
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'created_at_with_time' => verta($this->created_at)->format('H:m:s : %d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }

    public function GetDamOrDamvizhe($type)
    {
        $itemName = "";
        if (strval($type) == strval(Dam::class)) {
            $itemName = Dam::where('id', $this->factortable_id)->get('name')[0]["name"];
        } else {
            $itemName = Damvizhe::where('id', $this->factortable_id)->get('name')[0]["name"];
        }
        return $itemName;
    }

    public function GetDamOrDamvizhePrice($type)
    {
        $itemPrice = 0;
        if (strval($type) == strval(Dam::class)) {
            $itemPrice = Dam::where('id', $this->factortable_id)->get('price')[0]["price"];
        } else {
            $itemPrice = Damvizhe::where('id', $this->factortable_id)->get('disount_price')[0]["disount_price"];
        }
        return $itemPrice;
    }
}
