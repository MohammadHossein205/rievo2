<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Authimage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthimageController extends Controller
{
    public function index()
    {
        $authimageData = Authimage::first();
        return Inertia::render('AuthImage/Index', compact('authimageData'));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'login_image' => 'required',
            'register_image' => 'required',
        ]);
        $result = Authimage::updateOrCreate(
            ['id' => 1]
            ,
            [
                'login_image' => $request->login_image,
                'register_image' => $request->register_image,
            ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
