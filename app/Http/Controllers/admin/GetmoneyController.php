<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\GetmoneyResource;
use App\Models\Getmoney;
use App\Models\Payment;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GetmoneyController extends Controller
{
    public function index()
    {
        $getmoneyData = GetmoneyResource::collection(Getmoney::latest()->paginate(10));
        return Inertia::render('Getmoney/Index', compact('getmoneyData'));
    }

    public function GetAllGetMoneyData(Request $request)
    {
        $result = Getmoney::query();
        if ($request->input('search')) {
            $result = $result->where('user_id', 'LIKE', "%$request->search%")
                ->orWhere('cardnumber', 'LIKE', "%$request->search%")
                ->orWhere('money', 'LIKE', "%$request->search%")
                ->orWhere('resNumber', 'LIKE', "%$request->search%")
                ->orWhere('status', 'LIKE', "%$request->search%");
        }
        return GetmoneyResource::collection($result->latest()->paginate(10))->resource;
    }

    public function edit(Getmoney $getmoney)
    {
        return Inertia::render('Getmoney/Edit', compact('getmoney'));
    }

    public function update(Request $request, Getmoney $getmoney)
    {
        $validate = $request->validate([
            'resNumber' => 'required',
        ]);
        $result = $getmoney->update([
            'resNumber' => $request->resNumber,
            'updated_at' => Carbon::now(),
            'status' => 1,
        ]);
        $userWallet = Wallet::where('user_id', $getmoney->user_id)->first();
        $userwalletMoney = $userWallet->money;
        $userMoney = $userwalletMoney - $getmoney->money;
        $userWallet->update([
            'money' => $userMoney,
        ]);
        $payres = Payment::create([
            'user_id' => $getmoney->user_id,
            'payment_type' => 'کارت',
            'resNumber' => $request->resNumber,
            'discount' => 0,
            'discount_price' => 0,
            'price' => $getmoney->money,
            'card_number' => $getmoney->cardnumber,
            'status' => 1,
            'buyorsell' => 2,
        ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    public function destroy(Getmoney $getmoney)
    {
        if ($getmoney->delete()) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
