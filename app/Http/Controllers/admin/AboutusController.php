<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Aboutus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutusController extends Controller
{

    public function index()
    {

        if (!auth()->user()->hasPermissionTo('aboutus')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $aboutusData = Aboutus::latest()->first();
        return Inertia::render('Aboutus/Index', compact('aboutusData'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('aboutus')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validate = $request->validate([
            'big_title' => 'required|max:255',
            'small_title' => 'required|max:255',
            'big_text' => 'required',
            'about_text' => 'required',
            'image' => 'required',
        ]);
        $info = Aboutus::updateOrCreate(
            ['id' => 1]
            ,
            [
                'big_title' => $request->big_title,
                'small_title' => $request->small_title,
                'big_text' => $request->big_text,
                'about_text' => $request->about_text,
                'image' => $request->image,
            ]);
        return response()->json(200);
    }
}
