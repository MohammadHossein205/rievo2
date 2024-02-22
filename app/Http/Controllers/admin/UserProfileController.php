<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    public function index()
    {
        $userData = Auth::user();
        return Inertia::render('Profile/Index', compact('userData'));
    }

    public function update(Request $request, User $user)
    {
        $validation = $request->validate([
            'username' => 'required',
            'fullname' => 'required',
            'image' => 'required',
            'nationalCode' => 'required',
            'mobile' => 'required',
            'homeNumber' => 'required',
            'birthDate' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);
        $user->update([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'image' => $request->image,
            'nationalCode' => $request->nationalCode,
            'mobile' => $request->mobile,
            'homeNumber' => $request->homeNumber,
            'birthDate' => $request->birthDate,
            'email' => $request->email,
            'address' => $request->address,
        ]);
        return response()->json(200);
    }

    public function password()
    {
        $userData = Auth::user();
        return Inertia::render('Profile/ChangePassword', compact('userData'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return Response()->json(400);
        }
        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);
        return Response()->json(200);
    }
}
