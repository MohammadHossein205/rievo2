<?php

namespace App\Http\Resources\admin;

use App\Models\Dam;
use App\Models\Damvizhe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellResource extends JsonResource
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
            'user_name_id' => $this->user_id,
            'dam_id' => $this->GetDamOrDamvizhe($this->dam_type),
            'dam_type' => $this->dam_type,
            'dam_name_id' => $this->dam_id,
            'status' => $this->status,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }

    public function GetDamOrDamvizhe($type)
    {
        $damName = "";
        if (strval($type) == strval(Dam::class)) {
            $itemName = Dam::where('id', $this->dam_id)->get('name')[0]["name"];
        } else {
            $itemName = Damvizhe::where('id', $this->dam_id)->get('name')[0]["name"];
        }
        return $itemName;
    }
}
