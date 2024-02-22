<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Indexpagesetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexpagesettingController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index setting')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $indexsettingData = Indexpagesetting::latest()->first();
        return Inertia::render('IndexSetting/Index', compact('indexsettingData'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index setting')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validate = $request->validate([
            'top_big_text' => 'required',
            'top_small_text' => 'required',
            'top_big_description' => 'required',
            'estelam_text' => 'required',
            'baner_one_image' => 'required',
            'baner_one_image_link' => 'required',
            'baner_two_image' => 'required',
            'baner_two_image_link' => 'required',
            'more_information_title' => 'required',
            'more_information_text' => 'required',
            'phone_text' => 'required',
        ]);
        $info = Indexpagesetting::updateOrCreate(
            ['id' => 1]
            ,
            [
                'top_big_text' => $request->top_big_text,
                'top_small_text' => $request->top_small_text,
                'top_big_description' => $request->top_big_description,
                'estelam_text' => $request->estelam_text,
                'baner_one_image' => $request->baner_one_image,
                'baner_one_image_link' => $request->baner_one_image_link,
                'baner_two_image' => $request->baner_two_image,
                'baner_two_image_link' => $request->baner_two_image_link,
                'more_information_title' => $request->more_information_title,
                'more_information_text' => $request->more_information_text,
                'phone_text' => $request->phone_text,
            ]);
        return response()->json(200);
    }
}
