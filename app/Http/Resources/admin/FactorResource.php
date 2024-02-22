<?php

namespace App\Http\Resources\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactorResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'admin_show' => $this->admin_show,
            'IsMonthly' => $this->IsMonthly == 0 ? false : true,
            'expire_date' => verta($this->expire_date)->format('%d %B %Y'),
            'created_at' => verta($this->created_at)->format('%d %B %Y H:m:s'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
