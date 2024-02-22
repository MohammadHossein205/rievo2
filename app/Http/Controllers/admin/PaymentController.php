<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\PaymentDetailResource;
use App\Http\Resources\admin\PaymentRsource;
use App\Models\Mobile;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class PaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index payments')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $paymentData = PaymentRsource::collection(Payment::latest()->paginate(10));
        return Inertia::render('Payment/Index', compact('paymentData'));
    }

    public function GetAllPaymentData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index payments')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Payment::query();
        if ($request->input('search')) {
            $result = $result->where('user_id', 'LIKE', "%$request->search%")
                ->orWhere('payment_type', 'LIKE', "%$request->search%")
                ->orWhere('resNumber', 'LIKE', "%$request->search%")
                ->orWhere('discount', 'LIKE', "%$request->search%")
                ->orWhere('discount_price', 'LIKE', "%$request->search%")
                ->orWhere('price', 'LIKE', "%$request->search%");
        }
        return PaymentRsource::collection($result->latest()->paginate(10))->resource;
    }

    public function ShowDetail(Payment $payment)
    {
        if (!auth()->user()->hasPermissionTo('show detail payment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $paymentDetailData = PaymentDetailResource::collection(PaymentDetail::where('payment_id', $payment->id)->latest()->get());
        return Inertia::render('Payment/Detail', compact('paymentDetailData'));
    }

    public function payment(string $id)
    {
        $Result = "";
        $params = [
            "merchant" => "zibal",
//            "merchant" => "6549e453c3e0740012f97d44",
            "amount" => $id,
            "callbackUrl" => url()->to('admin/pay/checker' . '/' . $id),
            "description" => "Hello World!",
            "orderId" => "ZBL-7799",
            "mobile" => "09123456789"
        ];
        $response = Http::post('https://gateway.zibal.ir/v1/request', $params);
        if ($response->json('result') == 100) {
            $Result = Http::get("https://gateway.zibal.ir/start/" . $response['trackId']);
        }
        return $Result;
    }

    public function paymentMoney(string $id)
    {
        $Result = "";
        $params = [
            "merchant" => "zibal",
//            "merchant" => "6549e453c3e0740012f97d44",
            "amount" => $id,
            "callbackUrl" => url()->to('admin/pay/money/checker' . '/' . $id),
            "description" => "Hello World!",
            "orderId" => "ZBL-7799",
            "mobile" => "09123456789"
        ];
        $response = Http::post('https://gateway.zibal.ir/v1/request', $params);
        if ($response->json('result') == 100) {
            $Result = Http::get("https://gateway.zibal.ir/start/" . $response['trackId']);
        }
        return $Result;
    }

    public function money(string $id)
    {
        $Result = "";
        $params = [
            "merchant" => "zibal",
//            "merchant" => "6549e453c3e0740012f97d44",
            "amount" => $id,
            "callbackUrl" => url()->to('admin/pay/Moneychecker' . '/' . $id),
            "description" => "Hello World!",
            "orderId" => "ZBL-7799",
            "mobile" => "09123456789"
        ];
        $response = Http::post('https://gateway.zibal.ir/v1/request', $params);
        if ($response->json('result') == 100) {
            $Result = Http::get("https://gateway.zibal.ir/start/" . $response['trackId']);
        }
        return $Result;
    }

    public function Moneychecker(Request $request)
    {
        $params = [
            "merchant" => "zibal",
//            "merchant" => "6549e453c3e0740012f97d44",
            "trackId" => $request->trackId,
        ];
        $res = Http::post('https://gateway.zibal.ir/v1/verify', $params);
        if ($res->json('result') == 100) {
            $price = $request->id / 10;
            $wallet = Wallet::where('user_id', auth()->user()->id)->first();
            $money = $wallet->money;
            $newMoney = $price + $money;
            $wallet->update([
                'money' => $newMoney
            ]);
            return redirect('/user/wallet')->with('payment_result', 'success');
        } else {
            return redirect('/');
        }
    }

    public function checker(Request $request)
    {
        $params = [
            "merchant" => "zibal",
//            "merchant" => "6549e453c3e0740012f97d44",
            "trackId" => $request->trackId,
        ];
        $res = Http::post('https://gateway.zibal.ir/v1/verify', $params);
        $cardNumber = $res->json('cardNumber');
        if ($res->json('result') == 100) {
            $price = $request->id / 10;
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'payment_type' => 'کارت',
                'resNumber' => $request->trackId,
                'discount' => 0,
                'discount_price' => 0,
                'price' => $price,
                'card_number' => $cardNumber ?? 0,
                'IsMonthly' => 0,
                'status' => 1,
                'buyorsell' => 1,
            ]);
            return redirect('/user/pay/dam')->with('payment_result', 'success:' . $payment->id);
        } else {
            return redirect('/');
        }
    }

    public function checkerMoney(Request $request)
    {
        $params = [
            "merchant" => "zibal",
//            "merchant" => "6549e453c3e0740012f97d44",
            "trackId" => $request->trackId,
        ];
        $res = Http::post('https://gateway.zibal.ir/v1/verify', $params);
        $cardNumber = $res->json('cardNumber');
        if ($res->json('result') == 100) {
            $price = $request->id / 10;
            $wallet = Wallet::where('user_id', auth()->user()->id)->first();
            $userMoney = $wallet->money;
            $newMoney = $userMoney + intval($price);
            $wallet->update([
                'money' => $newMoney,
            ]);
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'payment_type' => 'کارت',
                'resNumber' => $request->trackId,
                'discount' => 0,
                'discount_price' => 0,
                'price' => $price,
                'card_number' => $cardNumber ?? 0,
                'status' => 1,
                'buyorsell' => 2,
            ]);
            return redirect('/user/wallet');
        } else {
            return redirect('/');
        }
    }


    private function checkPay(mixed $id, string $class)
    {
        $check = Payment::where('user_id', Auth::id())
            ->where('paymentable_id', $id)
            ->where('paymentable_type', $class)
            ->where('status', 0)
            ->first();
        return $check ?: false;
    }
}
