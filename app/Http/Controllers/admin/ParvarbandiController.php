<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DamIndexResource;
use App\Http\Resources\admin\GroupResource;
use App\Http\Resources\admin\ParvarbandiResource;
use App\Http\Resources\admin\ParvarbandiShowDamResource;
use App\Http\Resources\admin\ParvarbandiShowDaVizhemResource;
use App\Http\Resources\admin\UserIndexResource;
use App\Models\Chartprice;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Group;
use App\Models\Parvarbandi;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ParvarbandiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parvarbandiData = ParvarbandiResource::collection(Parvarbandi::latest()->paginate(10));
        return Inertia::render('Parvarbandi/Index', compact('parvarbandiData'));
    }

    public function GetParvarbandiData(Request $request)
    {
        $result = Parvarbandi::query();
        if ($request->input('search')) {
            $result = $result->where('user_id', 'LIKE', "%$request->search%")
                ->orWhere('dam_id', 'LIKE', "%$request->search%")
                ->orWhere('expire_date', 'LIKE', "%$request->search%");
        }
        return ParvarbandiResource::collection($result->latest()->paginate(10))->resource;
    }

    public function createindex()
    {
        $grouoData = GroupResource::collection(Group::latest()->get());
        return Inertia::render('Parvarbandi/CreateIndex', compact('grouoData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'expire_date' => 'required'
        ]);
        $date = $request->expire_date;
        $dateExplode = explode('/', $date);
//        $nowTime = Carbon::now()->setTimezone('Asia/Tehran')->format('H:m:s');
        $jalaliArrayDate = Verta::jalaliToGregorian($dateExplode[0], $dateExplode[1], $dateExplode[2]);
        $jalaliStringDate = $jalaliArrayDate[0] . '-' . $jalaliArrayDate[1] . '-' . $jalaliArrayDate[2];
        for ($i = 0; $i < count($request->user_id); $i++) {
            Parvarbandi::create([
                'user_id' => $request->user_id[$i],
                'dam_id' => $request->dam_id[$i],
                'dam_type' => $request->dam_type[$i],
                'expire_date' => $jalaliStringDate,
            ]);
        }
        return response()->json(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Parvarbandi $parvarbandi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parvarbandi $parvarbandi)
    {
        $parvarbandiData = ParvarbandiResource::make($parvarbandi);
        return Inertia::render('Parvarbandi/Edit', compact('parvarbandiData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parvarbandi $parvarbandi)
    {
        $validation = $request->validate([
            'expire_date' => 'required'
        ]);
        $date = $request->expire_date;
        $dateExplode = explode('/', $date);
//        $nowTime = Carbon::now()->setTimezone('Asia/Tehran')->format('H:m:s');
        $jalaliArrayDate = Verta::jalaliToGregorian($dateExplode[0], $dateExplode[1], $dateExplode[2]);
        $jalaliStringDate = $jalaliArrayDate[0] . '-' . $jalaliArrayDate[1] . '-' . $jalaliArrayDate[2];
        $result = $parvarbandi->update([
            'expire_date' => $jalaliStringDate,
        ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    public function AddParvarbandi(Request $request, Group $group)
    {
        $paymentDetailId = PaymentDetail::get(['paymentable_id']);
        $damDatas = ParvarbandiShowDamResource::collection(Dam::whereIn('id', $paymentDetailId)->where('group_id', $group->id)->get());
        $damvizheDatas = ParvarbandiShowDaVizhemResource::collection(Damvizhe::whereIn('id', $paymentDetailId)->where('group_id', $group->id)->get());
        return Inertia::render('Parvarbandi/ShowDam', compact('damDatas', 'damvizheDatas'));
    }

    public function DeleteDamInsertMohney(Request $request)
    {
        $parvarbandi = Parvarbandi::where('id', $request->parvarbandi_id)->first();
        $payment_dam = PaymentDetail::where('paymentable_id', $request->dam_id)->first();
        $damData = Dam::where('id', $request->dam_id)->first();
        $dam_price = Chartprice::where('group_id', $damData->group_id)->latest()->first();
        $damNewPrice = intval($damData->weight) * intval($dam_price->price);
        $user_wallet = Wallet::where('user_id', $request->user_id)->first();
        $sumMoney = $user_wallet->money + $damNewPrice;
        $result = $user_wallet->update([
            'money' => $sumMoney,
        ]);
        $result2 = $damData->update([
            'user_id' => 1,
            'status' => 1,
        ]);
        if ($result && $result2) {
            $payment_dam->delete();
            $parvarbandi->delete();
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parvarbandi $parvarbandi)
    {
        if ($parvarbandi->delete()) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
