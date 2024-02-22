<?php

namespace App\Http\Resources\admin;

use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Group;
use App\Models\Parvarbandi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParvarbandiShowDaVizhemResource extends JsonResource
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
            'dam_type' => Damvizhe::class,
            'group_id' => Group::where('id', $this->group_id)->get(['name'])[0]["name"] ?? '',
            'user_id' => $this->user->fullname ?? '',
            'user_id_id' => $this->user_id,
            'name' => $this->name,
            'hasParvarbandi' => $this->hasParvarbandi($this->id)
        ];
    }
    public function hasParvarbandi($dam_id)
    {
        $parvarbandi = Parvarbandi::where('dam_id', $dam_id)->first();
        if ($parvarbandi) {
            return true;
        } else {
            return false;
        }
    }
}
