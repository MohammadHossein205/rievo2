<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\WalletText;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WalletTextController extends Controller
{
    public function index()
    {
        $wallettextData = WalletText::first();
        return Inertia::render('WalletText/Index', compact('wallettextData'));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'title_text' => 'required',
            'title_description' => 'required',
            'about_wallet' => 'required',
        ]);
        $result = WalletText::updateOrCreate(
            ['id' => 1]
            ,
            [
                'title_text' => $request->title_text,
                'title_description' => $request->title_description,
                'about_wallet' => $request->about_wallet,
            ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
