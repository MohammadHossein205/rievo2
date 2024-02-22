<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DiscountCodeResource;
use App\Models\DiscountCode;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use function PHPUnit\Framework\isEmpty;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index discountcodes')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $discountCodeData = DiscountCodeResource::collection(DiscountCode::latest()->paginate(10));
        return Inertia::render('DiscountCode/Index', compact('discountCodeData'));
    }

    public function GetAllDiscountCodeData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index discountcodes')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = DiscountCode::query();
        if ($request->input('search')) {
            $result = $result->where('discount_code', 'LIKE', "%$request->search%")
                ->orWhere('price', 'LIKE', "%$request->search%")
                ->orWhere('end_time', 'LIKE', "%$request->search%");
        }
        return DiscountCodeResource::collection($result->latest()->paginate(10))->resource;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create discountcode')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $discountCode = $this->CreateDiscountUniqCode(10);
        return Inertia::render('DiscountCode/Create', compact('discountCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create discountcode')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $request->validate([
            'discount_code' => 'required|min:10|max:10',
            'price' => 'required',
            'count' => 'required',
            'end_time' => 'required',
        ]);
        $date = $request->end_time;
        $dateExplode = explode('/', $date);
//        $nowTime = Carbon::now()->setTimezone('Asia/Tehran')->format('H:m:s');
        $jalaliArrayDate = Verta::jalaliToGregorian($dateExplode[0], $dateExplode[1], $dateExplode[2]);
        $jalaliStringDate = $jalaliArrayDate[0] . '-' . $jalaliArrayDate[1] . '-' . $jalaliArrayDate[2];
        DiscountCode::create([
            'discount_code' => $request->discount_code,
            'price' => $request->price,
            'count' => $request->count,
            'end_time' => $jalaliStringDate,
        ]);
        return response()->json(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(DiscountCode $discountCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DiscountCode $discountcode)
    {
        if (!auth()->user()->hasPermissionTo('edit discountcode')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('DiscountCode/Edit', compact('discountcode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DiscountCode $discountcode)
    {
        if (!auth()->user()->hasPermissionTo('update discountcode')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $request->validate([
            'discount_code' => 'required|min:10|max:10',
            'price' => 'required',
            'count' => 'required',
            'end_time' => 'required',
        ]);
        $date = $request->end_time;
        $dateExplode = explode('/', $date);
//        $nowTime = Carbon::now()->setTimezone('Asia/Tehran')->format('H:m:s');
        $jalaliArrayDate = Verta::jalaliToGregorian($dateExplode[0], $dateExplode[1], $dateExplode[2]);
        $jalaliStringDate = $jalaliArrayDate[0] . '-' . $jalaliArrayDate[1] . '-' . $jalaliArrayDate[2];
        $discountcode->update([
            'discount_code' => $request->discount_code,
            'price' => $request->price,
            'count' => $request->count,
            'end_time' => $jalaliStringDate,
        ]);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiscountCode $discountcode)
    {
        if (!auth()->user()->hasPermissionTo('delete discountcode')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $discountcode->delete();
        return response()->json(200);
    }

    private function CreateDiscountUniqCode(string $lenght)
    {
        $AllDamCode = DiscountCode::latest()->get(['discount_code']);
        if (count($AllDamCode) != 0) {
            $Result = "";
            $Count = 0;
            while ($Count != 1) {
                $randCode = Str::upper(Str::random($lenght));
                foreach ($AllDamCode as $item) {
                    if ($item != $randCode) {
                        $Count = 1;
                        $Result = $randCode;
                    }
                }
            }
        } else {
            $Result = Str::upper(Str::random($lenght));
        }
        return $Result;
    }
}
