<?php

namespace App\Http\Controllers\home\factor;

use App\HelperTrait\SendInformationSms;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\FactorDetailResource;
use App\Http\Resources\admin\FactorResource;
use App\Http\Resources\admin\UserIndexResource;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Factor;
use App\Models\FactorDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FactorController extends Controller
{
    use SendInformationSms;

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index factors')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $factorData = FactorResource::collection(Factor::latest()->paginate(10));
        return Inertia::render('Factor/Index', compact('factorData'));
    }

    public function GetAllFactorData(Request $request)
    {
        $result = Factor::query();
        if ($request->input('search')) {
            $result = $result->where('title', 'LIKE', "%$request->search%")
                ->orWhere('description', 'LIKE', "%$request->search%");
        }
        return FactorResource::collection($result->latest()->paginate(10))->resource;
    }

    public function ShowDetail(Factor $factor)
    {
        if (!auth()->user()->hasPermissionTo('show detail factor')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $factorDetailData = FactorDetailResource::collection(FactorDetail::where('factor_id', $factor->id)->latest()->get());
        return Inertia::render('Factor/Detail', compact('factorDetailData'));
    }

    public function create()
    {
        $userData = UserIndexResource::collection(User::latest()->get());
        $damData = Dam::all();
        $damVizheData = Damvizhe::all();
        return Inertia::render('Factor/Create', compact('userData', 'damData', 'damVizheData'));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        $factor = Factor::query();
        $factorData = $factor->where('user_id', $request->user_id)->where('status', 1)->where('IsMonthly', 0)->get('id');
        $factordetailData = FactorDetail::whereIn('factor_id', $factorData)->get();
        $date = Carbon::today();
        $factor = Factor::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'admin_show' => 1,
            'expire_date' => $date->addDays(2),
            'IsMonthly' => 1,
            'status' => 0,
        ]);
        $month_money = $request->monthly_money;
        $resultMoney = round($month_money / $request->count);
        foreach ($factordetailData as $item) {
            $factorDetail = FactorDetail::create([
                'factor_id' => $factor->id,
                'factortable_id' => $item->factortable_id,
                'factortable_type' => $item->factortable_type,
                'count' => $item->count,
                'monthly_money' => $resultMoney,
                'status' => 0,
            ]);
        }
        if ($factor) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    public function GetUserDamData(Request $request)
    {
        $factor = Factor::query();
        $factorData = $factor->where('user_id', $request->user_id)->where('status', 1)->where('IsMonthly', 0)->get('id');
        $factordetailData = FactorDetail::whereIn('factor_id', $factorData)->get();
        return FactorDetailResource::collection($factordetailData);
    }

    public function update(Request $request, FactorDetail $factordetail)
    {
        $result = $factordetail->update([
            'monthly_money' => $request->monthly_money,
        ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    public function adminShow(Request $request, Factor $factor)
    {
        $res = $factor->update([
            'admin_show' => 1,
        ]);
        if ($res) {
            $smsData = $this->SendInformationSms($factor->user->mobile, 'CODE', 306132);
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    public function edit(Factor $factor)
    {
        return Inertia::render('Factor/Edit', compact('factor'));
    }

    public function updateFactor(Request $request, Factor $factor)
    {
        $validate = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $result = $factor->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    public function destroy(Factor $factor)
    {

        if ($factor->delete()) {
            if (FactorDetail::where('factor_id', $factor->id)->delete()) {
                return response()->json(200);
            } else {
                return response()->json(100);
            }
        } else {
            return response()->json(100);
        }
    }
}
