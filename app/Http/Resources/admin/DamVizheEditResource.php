<?php

namespace App\Http\Resources\admin;

use App\Models\Group;
use App\Models\GroupCompany;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DamVizheEditResource extends JsonResource
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
            'group_id' => $this->group_id,
            'group_company_id' => $this->group_company_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'image' => $this->galleries,
            'price' => $this->price,
            'weight' => $this->weight,
            'color' => $this->color,
            'colorenglish' => $this->colorenglish,
            'ageYear' => $this->ageYear,
            'ageMonth' => $this->ageMonth,
            'gender' => $this->gender,
            'haveMilk' => $this->haveMilk,
            'milk_amount' => $this->milk_amount,
            'description' => $this->description,
            'disount_price' => $this->disount_price,
            'disount_time' => $this->disount_time,
        ];
    }
}
