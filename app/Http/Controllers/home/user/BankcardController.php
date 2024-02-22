<?php

namespace App\Http\Controllers\home\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\BankcardResource;
use App\Models\Bankcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class BankcardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index bankcards')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $bankCardData = BankcardResource::collection(Bankcard::latest()->paginate(10));
        return Inertia::render('Bankcard/Index', compact('bankCardData'));
    }

    public function GetAllBankCardData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index bankcards')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Bankcard::query();
        if ($request->input('search')) {
            $result = $result->where('user_id', 'LIKE', "%$request->search%")
                ->orWhere('bankname', 'LIKE', "%$request->search%")
                ->orWhere('cardnumber', 'LIKE', "%$request->search%")
                ->orWhere('shabanumber', 'LIKE', "%$request->search%");
        }
        return BankcardResource::collection($result->latest()->paginate(10))->resource;
    }

    public function getUserInformationWithShaba(Request $request)
    {
//        $token = '30437539dc24496a9407f739db1e0989';
//        $result = Http::withHeaders([
//            'Content-Type: application/json',
//            'Authorization : Bearer ' . $token,
//        ])->post('https://api.zibal.ir/v1/facility/ibanInquiry', ['IBAN' => $request->shabanumber]);
//        return $result;
        $path = 'facility/cardInquiry';
        $apiKey = 'e6009714611642f78cfa1bbcdb7a7bef';
        $parameters = [
            "cardNumber" => "$request->cardnumber",
        ];
        $url = 'https://api.zibal.ir/v1/' . $path;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        if ($response == null)
            return (object)['message' => 'خطا در ارتباط با زیبال', 'result' => -1];
        return json_decode($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bankCard = Bankcard::create([
            'user_id' => $request->user_id,
            'bankname' => $request->bank_name,
            'image' => $request->image,
            'cardnumber' => $request->card_number,
            'shabanumber' => $request->shaba_number,
            'status' => false,
        ]);
        return 100;
    }

    public function GetCard(Request $request)
    {
        $bankCard = Bankcard::where('user_id', $request->user_id)->get();
        if ($bankCard) {
            return $bankCard;
        } else {
            return 100;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bankcard $bankcard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bankcard $bankcard)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bankcard $bankcard)
    {

    }

    public function StatusBankCard(Request $request, string $id)
    {
        if (!auth()->user()->hasPermissionTo('status bankcard')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $bankcard = Bankcard::where('id', $id)->first();
        $bankcard->update([
            'status' => $request->status,
        ]);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bankcard $bankcard)
    {
        if (!auth()->user()->hasPermissionTo('delete bankcard')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        if ($bankcard->delete()) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
