<?php

namespace App\Http\Resources\admin;

use App\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParvarbandiResource extends JsonResource
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
            'user_id' => User::where('id', $this->user_id)->first()->fullname ?? 'ندارد',
            'user_id_id' => $this->user_id,
            'dam_id' => $this->dam->name ?? 'ندارد',
            'dam_id_id' => $this->dam_id,
            'expire_date_shamsi' => verta($this->expire_date)->format('Y/m/d'),
            'expire_date' => verta($this->expire_date)->format('%d %B %Y'),
            'created_at' => verta($this->created_at)->format('%d %B %Y'),
            'updated_at' => verta($this->updated_at)->format('%d %B %Y'),
            'parvarbandi_Expire' => $this->checkEndParvarbandi($this->created_at, $this->expire_date, Carbon::now()),
        ];
    }

    public function checkEndParvarbandi($create_date, $expire_date, $now_date)
    {
        $cr_date = Carbon::createFromDate($create_date);
        $ex_date = Carbon::createFromDate($expire_date);
        $online_date = Carbon::createFromDate($now_date);
        $diffdayBetweenStartAndExpire = $cr_date->diffInDays($ex_date, false);
        $diffdayBetweenStartAndNow = $cr_date->diffInDays($online_date, false);
        $trueFalse = false;
        if ($diffdayBetweenStartAndExpire >= $diffdayBetweenStartAndNow) {
            $trueFalse = true;
        }
        return $trueFalse;
    }
}
