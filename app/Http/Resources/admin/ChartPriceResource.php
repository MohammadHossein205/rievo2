<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChartPriceResource extends JsonResource
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
            'group_id' => $this->group->name??'ندارد',
            'price' => number_format($this->price, 0, '.', ','),
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'created_at_chart' => verta($this->created_at)->format('%d - %m - %Y'),
            'updated_at' => verta($this->updated_at)->formatDifference(),
        ];
    }
}
