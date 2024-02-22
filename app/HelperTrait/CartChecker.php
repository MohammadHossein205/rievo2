<?php

namespace App\HelperTrait;

use App\Models\Cart;
use App\Models\FactorDetail;
use Carbon\Carbon;

trait CartChecker
{
    public function CartCheck()
    {
        $day = Carbon::today();
        $cart = Cart::all();
        for ($i = 0; $i < count($cart); $i++) {
            $item = $cart[$i]->expire_date;
            $day->diffInDays($item, false);
            if ($day->diffInDays($item, false) <= 0) {
                $cart[$i]->delete();
            }
        }
    }
}
