<?php

namespace App\Http\Resources\admin;

use App\Models\Group;
use App\Models\GroupCompany;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DamvizheResource extends JsonResource
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
            'group_id' => Group::where('id', $this->group_id)->get(['name'])[0]["name"] ?? '',
            'group_id_org' => $this->group_id,
            'group_company_id' => GroupCompany::where('id', $this->group_company_id)->get(['name'])[0]["name"] ?? '',
            'group_english' => GroupCompany::where('id', $this->group_company_id)->get(['english_name'])[0]["english_name"] ?? '',
            'user_id' => $this->user_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'image' => $this->galleries,
            'price' => number_format($this->price, 0, '.', ','),
            'price_org' => $this->price,
            'weight' => $this->weight,
            'color' => $this->color,
            'colorenglish' => $this->colorenglish,
            'ageYear' => $this->ageYear,
            'ageMonth' => $this->ageMonth,
            'gender' => $this->gender == 1 ? 'نر' : 'ماده',
            'haveMilk' => $this->haveMilk == 1 ? 'شیری' : 'پرواری',
            'milk_amount' => $this->milk_amount ?? 'ندارد',
            'description' => $this->description,
            'disount_price' => number_format($this->disount_price, 0, '.', ','),
            'disount_price_org' => $this->disount_price,
            'disount_time' => verta($this->disount_time)->format('%d %B %Y'),
            'disount_time_defult' => $this->disount_time,
            'model_type' => $this->resource::class,
            'status' => $this->status,
//            'like' => $this->likes()->count(),
            'comments' => $this->comments,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'dam_time' => verta($this->created_at)->diffMonths(),
        ];
    }
}
