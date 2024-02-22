<?php

namespace App\Http\Resources\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetmoneyResource extends JsonResource
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
            'user_id' => User::where('id', $this->user_id)->get('fullname')[0]["fullname"] ?? 'ندارد',
            'cardnumber' => $this->cardnumber,
            'money' => $this->money,
            'resNumber' => $this->resNumber,
            'status' => $this->status,
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
        ];
    }
}
