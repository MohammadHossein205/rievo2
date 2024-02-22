<?php

namespace App\Http\Controllers\home\factor;

use App\HelperTrait\SendInformationSms;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\FactorDetailResource;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Factor;
use App\Models\FactorDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FactorDetailController extends Controller
{
    use SendInformationSms;

    public function CreateFactor(Request $request)
    {
        $date = Carbon::today();
        $factor = Factor::create([
            'user_id' => auth()->user()->id,
            'title' => '',
            'description' => '',
            'expire_date' => $date->addDays(2),
            'status' => false,
        ]);
        $adminMobile = User::where('id', 1)->first();
        $this->SendInformationSms($adminMobile->mobile, 'CODE', 483818);
        return $factor;
    }

    public function CreateDetailFactor(Request $request)
    {
        $factorDetail = FactorDetail::create([
            'factor_id' => $request->factor,
            'factortable_id' => $request->dam,
            'count' => $request->dam_count,
            'factortable_type' => $request->dam_type == strval(Dam::class) ? Dam::class : Damvizhe::class,
        ]);
        if ($factorDetail) {
            return 200;
        } else {
            return 100;
        }
    }

    public function GetDetailFactor(Request $request)
    {
        $detail_factor = FactorDetail::where('factor_id', $request->factor_id)->get();
        if ($detail_factor)
            return $detail_factor;
        else
            return 100;
    }

    public function SumMoney(Request $request)
    {
        $damMoney = $request->damMoney;
        $tax = $request->tax;
        $commission = $request->commission;
        $MonthlyMoney = $request->MonthlyMoney;
        $sumMoney = 0;
        for ($i = 0; $i < count($MonthlyMoney); $i++) {
            $sumMoney += floatval($damMoney[$i]) + floatval($tax[$i]) + floatval($commission[$i]) + floatval($MonthlyMoney[$i]);
        }
        return $sumMoney;
    }

    public function MonthlySumMoney(Request $request)
    {
        return $request;
        $tax = $request->tax;
        $commission = $request->commission;
        $MonthlyMoney = $request->MonthlyMoney;
        $sumMoney = 0;
        for ($i = 0; $i < count($MonthlyMoney); $i++) {
            $sumMoney += floatval($tax[$i]) + floatval($commission[$i]) + floatval($MonthlyMoney[$i]);
        }
        return $sumMoney;
    }

}
