<?php

namespace App\Http\Controllers;

use App\Models\Dashboardsetting;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginWithGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        if ($userData = $this->UserExist($user->getEmail())) {
            Auth::loginUsingId($userData->id, true);
        } else {
            $newUser = User::create([
                'username' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => Hash::make($user->getEmail()),
                'image' => '',
                'level' => 0,
                'discount_id' => '',
                'fullname' => '',
                'nationalCode' => '',
                'mobile' => '',
                'homeNumber' => '',
                'birthDate' => Carbon::now()
                    ->format('Y-m-d'),
                'changed_password' => Carbon::parse(),
                'address' => '',
                'email_verified_at' => Carbon::now(),
            ]);
            $wallet = Wallet::create([
                'user_id' => $newUser->id,
                'money' => 0,
            ]);
            $setting = Dashboardsetting::create([
                'user_id' => $newUser->id,
                'email_notification' => 0,
                'new_order_accept_sms' => 0,
                'new_order_cancel_sms' => 0,
            ]);
            Auth::loginUsingId($newUser->id, true);
        }
        return redirect()->route('home.user.dashboard');
    }

    private function UserExist(string $getEmail)
    {
        $check = User::where('email', $getEmail)
            ->first();

        return $check ?: false;
    }
}
