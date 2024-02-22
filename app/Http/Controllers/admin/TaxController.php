<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaxController extends Controller
{
    public function index()
    {
        $taxData = Tax::first();
        return Inertia::render('Taxs/Index', compact('taxData'));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'tax' => 'required',
            'commission' => 'required',
        ]);
        $result = Tax::updateOrCreate(
            ['id' => 1]
            ,
            [
                'tax' => $request->tax,
                'commission' => $request->commission,
            ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
