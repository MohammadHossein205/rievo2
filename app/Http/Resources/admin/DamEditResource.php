<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DamEditResource extends JsonResource
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
            'color_english' => $this->color_english,
            'ageYear' => $this->ageYear,
            'ageMonth' => $this->ageMonth,
            'gender' => $this->gender,
            'haveMilk' => $this->haveMilk,
            'milk_amount' => $this->milk_amount,
            'description' => $this->description,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
        ];
    }
}
