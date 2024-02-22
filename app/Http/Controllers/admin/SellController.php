<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\SellResource;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Sell;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SellController extends Controller
{
    public function index()
    {
        $selldamData = SellResource::collection(Sell::latest()->paginate(10));
        return Inertia::render('Sells/Index', compact('selldamData'));
    }

    public function GetSellDamData(Request $request)
    {
        $result = Sell::query();
        if ($request->input('search')) {
            $result = $result->where('user_id', 'LIKE', "%$request->search%")
                ->orWhere('dam_id', 'LIKE', "%$request->search%")
                ->orWhere('status', 'LIKE', "%$request->search%");
        }
        return SellResource::collection($result->latest()->paginate(10))->resource;
    }

    public function create(Request $request)
    {
        $id = $request->id;
        $user_id = auth()->user()->id;
        if ($request->type == 'normal') {
            $sell = Sell::create([
                'user_id' => $user_id,
                'dam_id' => $id,
                'dam_type' => Dam::class,
                'status' => 0,
            ]);
            if ($sell) {
                return $sell;
            } else {
                return 100;
            }
        } else {
            $sell = Sell::create([
                'user_id' => $user_id,
                'dam_id' => $id,
                'dam_type' => Damvizhe::class,
                'status' => 0,
            ]);
            if ($sell) {
                return $sell;
            } else {
                return 100;
            }
        }
    }

    public function store(Request $request)
    {
        if ($request->dam_type == Dam::class) {
            $damData = Dam::where('id', $request->dam_id)->first();
            $result = $damData->update([
                'price' => $request->price,
                'status' => 1,
            ]);

//        return $request->user_id;
            $payment = Payment::create([
                'user_id' => $request->user_id,
                'payment_type' => 'فروش',
                'resNumber' => '',
                'discount' => 0,
                'discount_price' => 0,
                'price' => $request->price,
                'card_number' => 0,
                'status' => 1,
                'buyorsell' => 0,
            ]);
            $paymentDetail = PaymentDetail::where('paymentable_id', $request->dam_id)->where('paymentable_type', Dam::class)->first()->update(['payment_id' => $payment->id]);
            $sellData = Sell::where('dam_id', $request->dam_id)->where('dam_type', Dam::class)->first()->update(['status' => 1]);
            if ($result) {
                return response()->json(200);
            } else {
                return response()->json(100);
            }
        } else {
            $damvizheData = Damvizhe::where('id', $request->dam_id)->first();
            $result = $damvizheData->update([
                'disount_price' => $request->price,
                'status' => 1,
            ]);
//        return $request->user_id;
            $sellData = Sell::where('dam_id', $request->dam_id)->where('dam_type', Damvizhe::class)->first()->update(['status' => 1]);
            $payment = Payment::create([
                'user_id' => $request->user_id,
                'payment_type' => 'فروش',
                'resNumber' => '',
                'discount' => '',
                'discount_price' => '',
                'price' => $request->price,
                'card_number' => 0,
                'status' => 1,
                'buyorsell' => 0,
            ]);
            $paymentDetail = PaymentDetail::where('paymentable_id', $request->dam_id)->where('paymentable_type', Damvizhe::class)->first()->update(['payment_id' => $payment->id]);
            if ($result) {
                return response()->json(200);
            } else {
                return response()->json(100);
            }
        }
    }

    public function CheckSell(Request $request)
    {
        $id = $request->id;
        $sells = Sell::where('dam_type', strval(Dam::class))->latest()->get();
        for ($i = 0; $i < count($sells); $i++) {
            if ($sells[$i]->dam_id == $id) {
                return true;
            }
        }
        return false;
    }

    // bayad baraye dam vizhe ham check besh ke aya frokhte shodan ya na
    public function CheckSellVizhe(Request $request)
    {
        $id = $request->id;
        $sells = Sell::where('dam_type', strval(Damvizhe::class))->latest()->get();
        for ($i = 0; $i < count($sells); $i++) {
            if ($sells[$i]->dam_id == $id) {
                return true;
            }
        }
        return false;
    }

    public function CheckSellConfirmed(Request $request)
    {
        $id = $request->id;
        $sells = Sell::where('dam_type', strval(Dam::class))->where('dam_id', $id)->first();
        if ($sells) {
            if ($sells->status == true) {
                return true;
            } else
                return false;
        } else
            return false;
    }

    public function CheckSellConfirmedVizhe(Request $request)
    {
        $id = $request->id;
        $sells = Sell::where('dam_type', strval(Damvizhe::class))->where('dam_id', $id)->first();
        if ($sells) {
            if ($sells->status == 1) {
                return 1;
            } else
                return 0;
        } else
            return 0;
    }

    public function CancelSell(string $id)
    {
        $sell = Sell::where('dam_id', $id)->first();
        $sell->delete();
        return 200;
    }

    public function showSellDetailData(Sell $sell)
    {
        $sellData = SellResource::make($sell);
        return Inertia::render('Sells/ShowSellDetail', compact('sellData'));
    }

    public function destroy(Sell $sell)
    {
        if ($sell->delete()) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
