<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentCondition;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentConditionController extends Controller
{
    public function index()
    {
        $paymentconditionData = PaymentCondition::latest()->first();
        return Inertia::render('PaymentCondition/Index', compact('paymentconditionData'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title_text' => 'required',
            'body_text' => 'required',
            'image' => 'required',
        ]);
        $info = PaymentCondition::updateOrCreate(
            ['id' => 1]
            ,
            [
                'title_text' => $request->title_text,
                'body_text' => $request->body_text,
                'image' => $request->image,
            ]);
        return response()->json(200);
    }
}
