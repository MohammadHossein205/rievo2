<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\ContactusResource;
use App\Models\Contactus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactusController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('contactus')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $contactusData = Contactus::latest()->first();
        return Inertia::render('Contactus/Index', compact('contactusData'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('contactus')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validate = $request->validate([
            'location_image' => 'required',
            'location_link' => 'required',
            'face_to_face' => 'required|max:255',
            'link_way' => 'required',
            'email' => 'required|email',
            'telegram' => 'required',
            'instagram' => 'required',
            'whatsapp' => 'required',
            'eitaa' => 'required',
            'rubika' => 'required',
        ]);
        $info = Contactus::updateOrCreate(
            ['id' => 1]
            ,
            [
                'location_image' => $request->location_image,
                'location_link' => $request->location_link,
                'face_to_face' => $request->face_to_face,
                'link_way' => $request->link_way,
                'email' => $request->email,
                'telegram' => $request->telegram,
                'instagram' => $request->instagram,
                'whatsapp' => $request->whatsapp,
                'eitaa' => $request->eitaa,
                'rubika' => $request->rubika,
            ]);
        return response()->json(200);
    }
}
