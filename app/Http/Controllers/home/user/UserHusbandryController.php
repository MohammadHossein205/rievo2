<?php

namespace App\Http\Controllers\home\user;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\ChartPriceResource;
use App\Http\Resources\admin\DamIndexResource;
use App\Http\Resources\admin\DamvizheResource;
use App\Http\Resources\admin\FactorResource;
use App\Http\Resources\admin\FullPriceResource;
use App\Http\Resources\admin\PaymentDetailResource;
use App\Models\Chartprice;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Factor;
use App\Models\FactorDetail;
use App\Models\FullPrice;
use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Http\Request;

class
UserHusbandryController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | دامداری کاربر'
            , 'نمایش اطلاعات دام های کاربر'
            , 'https://rievo.ir/user/husbandry'
            , 'نمایش اطلاعات دام های کاربر'
            , 'ریوو | دامداری کاربر'
            , 'https://rievo.ir/user/husbandry'
            , 'user/husbandry'
            , 'دامداری ریوو'
            , 'ریوو | دامداری کاربر'
            , '@rievo'
            , 'ریوو | دامداری کاربر'
            , 'نمایش اطلاعات دام های کارب'
            , asset('img/logo/header_logo.svg'));
        $allPayments = Payment::query();
        $payments_user = $allPayments->where('user_id', auth()->user()->id)->where('status', 1)->where('IsMonthly', 0)->get('id');
        $payments_buy = $allPayments->where('user_id', auth()->user()->id)->where('status', 1)->where('buyorsell', 1)->where('IsMonthly', 0)->get('id');
        $allPayments2 = Payment::query();
        $payments_sell = $allPayments2->where('user_id', auth()->user()->id)->where('status', 1)->where('buyorsell', 0)->where('IsMonthly', 0)->get('id');
//
        $payments_detail = PaymentDetail::query();
        $user_dam = $payments_detail->whereIn('payment_id', $payments_user)->get();
        $buy_dam = $payments_detail->whereIn('payment_id', $payments_buy)->get();
        $payments_detail2 = PaymentDetail::query();
        $sell_dam = $payments_detail2->whereIn('payment_id', $payments_sell)->get();

//

        $payments = Payment::where('user_id', auth()->user()->id)->get();
        $factors = FactorResource::collection(Factor::where('user_id', auth()->user()->id)->where('admin_show', 1)->latest()->get());
        $today = '';
        foreach ($factors as $factor) {
            if ($factor->admin_show == 1 && $factor->status == 0) {
                $today = verta($factor->created_at)->format('%d %B %Y');
            }
        }
        $sum_sell = 0;
        $sum_dam = 0;
        $sum_buy = 0;
        $money_buy_dam = Payment::where('user_id', auth()->user()->id)->where('status', 1)->where('buyorsell', 1)->where('IsMonthly', 0)->get('price');
        $money_sell_dam = Payment::where('user_id', auth()->user()->id)->where('status', 1)->where('buyorsell', 0)->where('IsMonthly', 0)->get('price');
        $money_user_dam = Payment::where('user_id', auth()->user()->id)->where('status', 1)->where('IsMonthly', 0)->get('price');


        foreach ($money_buy_dam as $buy)
            $sum_buy += intval($buy->price);
        foreach ($money_sell_dam as $sell)
            $sum_sell += intval($sell->price);
        foreach ($money_user_dam as $user)
            $sum_dam += intval($user->price);

        $user_dam_count = 0;
        $sell_dam_count = 0;
        $buy_dam_count = 0;
        foreach ($user_dam as $item) {
            $user_dam_count += $item->count;
        }
        foreach ($sell_dam as $item) {
            $sell_dam_count += $item->count;
        }
        foreach ($buy_dam as $item) {
            $buy_dam_count += $item->count;
        }
        return view('home.user.husbandry.index', compact('factors', 'today', 'payments', 'user_dam_count', 'sell_dam_count', 'buy_dam_count', 'buy_dam', 'sell_dam', 'user_dam', 'sum_sell', 'sum_dam', 'sum_buy'));
    }

    public function GetUserPaymentDetailForDam(Request $request)
    {
        $id = $request->id;
        $paymentDetail = PaymentDetail::where('payment_id', $id)->distinct()->get();
        return $paymentDetail;
    }

    public function GetUserPaymentDetailForDamArray(Request $request)
    {
        $paymentDetail = PaymentDetail::whereIn('payment_id', $request)->distinct()->get();
        return $paymentDetail;
    }

    public function GetUserPaymentDetailForDamResource(Request $request)
    {
        $paymentDetail = PaymentDetailResource::collection(PaymentDetail::where('payment_id', $request->id)->get());
        return $paymentDetail;
    }

    public function GetUserPaymentDetailForDamResourceArray(Request $request)
    {
        $paymentDetail = PaymentDetail::query();
        return PaymentDetailResource::collection($paymentDetail->whereIn('payment_id', $request)->get());
//        return $paymentDetail->whereIn('payment_id', $request)->get());
    }

    public function GetUserPaymentDetailForDamId(Request $request)
    {
        $paymentDetail = PaymentDetail::where('paymentable_id', $request->id)->get();
        return $paymentDetail;
    }

    public function GetUserFactorDetailForDam(Request $request)
    {
        $factorDetail = FactorDetail::whereIn('factor_id', $request)->get();
        return $factorDetail;
    }

    public function GetUserFactorDetailForEachDam(Request $request)
    {
        $dam = Dam::where('id', $request->id)->get();
        $dam_price = $dam[0]->price;
//        $factorDetail = FactorDetail::where('factor_id', $request->id)->get();
        return $dam_price;
    }

    public function GetUserDam(Request $request)
    {
        return DamIndexResource::collection(Dam::whereIn('id', $request)->get());
    }

    public function GetUserDamVizhe(Request $request)
    {
        return DamvizheResource::collection(Damvizhe::whereIn('id', $request)->get());
    }


    public function GetUserDamGroupId(Request $request)
    {
        $dam = Dam::where('id', $request->id)->get();
        return $dam[0]->group_id;
    }

    public function FillChart(Request $request)
    {
        $id = $request->group_id;
        $chartPrice = ChartPriceResource::collection(Chartprice::where('group_id', $id)->latest()->get());
        return $chartPrice;
    }

    public function FillChartArray(Request $request)
    {

        $GroupIdArray = $request->all();
        $ChartPriceQuery = Chartprice::query();
        $chartPrice = [];
        $chartPrice = $ChartPriceQuery->whereIn('group_id', $GroupIdArray)->latest()->get();
        return $chartPrice;
    }

    public function FillChartArrayAll()
    {
        return Chartprice::all();
    }

    public function CheckFullPrice()
    {
        $fullPrice = FullPriceResource::collection(FullPrice::where('user_id', auth()->user()->id)->get());
        return $fullPrice;
    }

    public function SetFullPrice(Request $request)
    {
        $price = $request->price;
        $fullPrice = FullPrice::create([
            'user_id' => auth()->user()->id,
            'price' => $price,
        ]);
        if ($fullPrice) {
            return 200;
        } else
            return 100;
    }

    public function UpdateFullPrice(Request $request)
    {
        $price = $request->price;
        $fullPrice = FullPrice::where('user_id', auth()->user()->id)->latest()->first();
        if (strval($fullPrice->price) != strval($price)) {
            $fullPrice->update([
                'price' => $price
            ]);
            return 200;
        }
        return 100;
    }
}
