<?php

namespace App\Http\Controllers\home\user;

use App\HelperTrait\SendInformationSms;
use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\DiscountCode;
use App\Models\Factor;
use App\Models\Getmoney;
use App\Models\Payment;
use App\Models\PaymentCondition;
use App\Models\PaymentDetail;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserWalletController extends Controller
{
    use SeoPage, SendInformationSms;

    public function index()
    {
        $this->SeoPage('ریوو | کیف پول کاربر'
            , 'نمایش اطلاعات کیف پول کاربر'
            , 'https://rievo.ir/user/wallet'
            , 'نمایش اطلاعات کیف پول کاربر'
            , 'ریوو | کیف پول کاربر'
            , 'https://rievo.ir/user/wallet'
            , 'user/wallet'
            , 'دامداری ریوو'
            , 'ریوو | کیف پول کاربر'
            , '@rievo'
            , 'ریوو | کیف پول کاربر'
            , 'نمایش اطلاعات کیف پول کاربر'
            , asset('img/logo/header_logo.svg'));
        $id = auth()->user()->id;
        $wallet = Wallet::where('user_id', $id)->first();
        $payment_condition = PaymentCondition::first();
        return view('home.user.wallet.index', compact('wallet', 'payment_condition'));
    }

    public function AddMoney(Request $request)
    {
        $validate = $request->validate([
            'money' => 'required|digits_between:1,1000000000'
        ]);
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        $oldMoney = $request->money;
        if ($oldMoney == 0) {
            return 0;
        }
        if ($oldMoney > 10000000) {
            return 100;
        }
        $currentMoney = $wallet->money;
        $newMoney = $oldMoney + $currentMoney;

        $wallet->update([
            'money' => $newMoney
        ]);
        return 200;
    }

    public function UserPaymentDetail(Request $request)
    {
        $dam_id = $request->dam_id;
//        $check = PaymentDetail::query();
//        if (!$check->where('paymentable_id', $dam_id)->first()) {
        $dam_count = $request->dam_count;
        $payment_id = $request->payment_id;
        $payment_type = $request->type;
        if ($request->type == strval(Dam::class)) {
            $payment_detail = PaymentDetail::create([
                'payment_id' => $payment_id,
                'paymentable_id' => $dam_id,
                'paymentable_type' => Dam::class,
                'description' => '',
                'count' => $dam_count,
            ]);
            $dam = Dam::where('id', $dam_id)->first();
            $dam->update([
                'status' => 0,
                'user_id' => auth()->user()->id,
            ]);
            $payment = Payment::where('id', $payment_id)->first();
            $payment->update(['IsMonthly' => $request->IsMonthly == 'true' ? 1 : 0]);
            if ($request->payment_discount) {
                $payment->update(['discount_price' => $request->payment_discount]);
            }
            if ($payment_detail) {
                return 200;
            } else
                return 100;
        } else if ($request->type == strval(Damvizhe::class)) {
            $payment_detail = PaymentDetail::create([
                'payment_id' => $payment_id,
                'paymentable_id' => $dam_id,
                'paymentable_type' => Damvizhe::class,
                'description' => '',
                'count' => $dam_count,
            ]);
            $dam = Damvizhe::where('id', $dam_id)->first();
            $dam->update([
                'status' => 0,
                'user_id' => auth()->user()->id,
            ]);
            $payment = Payment::where('id', $payment_id)->first();
            $payment->update(['IsMonthly' => $request->IsMonthly == 'true' ? 1 : 0]);
            if ($request->payment_discount) {
                $payment->update(['discount_price' => $request->payment_discount]);
            }
            if ($payment_detail) {
                return 200;
            } else
                return 100;
        }
//        }
    }

    public function UserPayment(Request $request)
    {
        if (!$request->user_discount)
            $request->user_discount = 0;
        $giveMoney = $request->giveMoney;
        $discount_price = $request->discount_price;
        $factor = Factor::where('id', $request->factor_id)->first();
        $factor->update([
            'status' => 1
        ]);
        $payment_id = $request->payment_id;
        if ($request->payment_time == 0) {
            $payment = Payment::create([
                'user_id' => auth()->user()->id,
                'payment_type' => $request->payment_type,
                'resNumber' => 0,
                'discount' => 0,
                'discount_price' => $discount_price,
                'price' => $giveMoney,
                'card_number' => 0,
                'IsMonthly' => $request->IsMonthly == 'true' ? 1 : 0,
                'status' => 1,
                'buyorsell' => 1,
            ]);
            $payment_id = $payment->id;
        }
        $payment_detail = PaymentDetail::create([
            'payment_id' => $payment_id,
            'paymentable_id' => $request->paymentable_id,
            'paymentable_type' => $request->paymentable_type,
            'description' => '',
            'count' => $request->dam_count,
        ]);
        if ($request->paymentable_type == strval(Dam::class)) {
            $dam = Dam::where('id', $request->paymentable_id)->first();
            $dam->update([
                'status' => 0,
                'user_id' => auth()->user()->id,
            ]);
        } else {
            $dam = Damvizhe::where('id', $request->paymentable_id)->first();
            $dam->update([
                'status' => 0,
                'user_id' => auth()->user()->id,
            ]);
        }

        return $payment_id;
    }

    public function CheckDiscount(Request $request)
    {
        $discount_price = 0;
        $discount_id = auth()->user()->discount_id;
        if ($discount_id != '') {
            $discount = DiscountCode::where('id', $discount_id)->where('end_time', '>=', Carbon::now())->first();
            if ($discount) {
                $discount_code = $discount->discount_code;
                if ($discount_code == $request->discount_code) {
                    if ($discount->count > 1) {
                        $discount_price = $discount->price;
                        $discount_count = $discount->count - 1;
                        $discount->update([
                            'count' => $discount_count
                        ]);
                    } else {
                        $discount_price = $discount->price;
                        $discount->delete();
                        $user = User::where('id', auth()->user()->id)->first();
                        $user->update([
                            'discount_id' => null
                        ]);
                    }
                    return $discount_price;
                } else {
                    return 'wrong_code';
                }
            } else {
                return 'error_id';
            }
        } else {
            return 'error_id';
        }
    }

    public
    function AddDiscount()
    {
        $user_discount = auth()->user()->discount_id;
        $discount = DiscountCode::where('id', $user_discount)->first();
        $discount_count = $discount->count;
        $discount_count += 1;
        $discount->update([
            'count' => $discount_count
        ]);
    }

    public
    function GiveMoney(Request $request)
    {
        $validate = $request->validate([
            'giveMoney' => 'required|digits_between:1,1000000000'
        ]);

//        money
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        $giveMoney = $request->giveMoney;
        if ($giveMoney == 0) {
            return 0;
        }

        $currentMoney = $wallet->money;
        $newMoney = $currentMoney - $giveMoney;
        if ($newMoney < 0) {
            return 400;
        }
        $wallet->update([
            'money' => $newMoney
        ]);
//        money

        return 200;
    }

    public function SetGiveMoney(Request $request)
    {
        $GetMoney = Getmoney::create([
            'user_id' => auth()->user()->id,
            'cardnumber' => $request->cardNumber,
            'money' => $request->giveMoney,
            'status' => 0,
        ]);
        if ($GetMoney) {
            return 200;
        } else {
            return 100;
        }
    }

    public
    function FactorStatus(Request $request)
    {
        $factor = Factor::where('id', $request->factor_id)->first();
        $factor->update([
            'status' => 1
        ]);
    }

    public
    function GetUserMoney(Request $request)
    {
        $id = $request->user_id;
        $wallet = Wallet::where('user_id', $id)->first();
        return $wallet->money;
    }
}
