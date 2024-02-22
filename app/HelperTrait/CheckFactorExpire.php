<?php

namespace App\HelperTrait;

use App\Models\Factor;
use App\Models\FactorDetail;
use Carbon\Carbon;

trait CheckFactorExpire
{
    public function CheckFactor()
    {
        $day = Carbon::today();
        $factor = Factor::all();
        for ($i = 0; $i < count($factor); $i++) {
            $item = $factor[$i]->expire_date;
            if ($day->diffInDays($item, false) <= 0 && $factor[$i]->status == 0) {
                $factorDetail = FactorDetail::where('factor_id', $factor[$i]->id)->delete();
                $factor[$i]->delete();
            }
        }
    }
}
