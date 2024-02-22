<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\HusbandryText;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HusbandryTextController extends Controller
{
    public function index()
    {
        $husbandryData = HusbandryText::first();
        return Inertia::render('HusbandryText/Index', compact('husbandryData'));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'title_text' => 'required',
            'title_description' => 'required',
        ]);
        $result = HusbandryText::updateOrCreate(
            ['id' => 1]
            ,
            [
                'title_text' => $request->title_text,
                'title_description' => $request->title_description,
            ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
