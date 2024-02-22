<?php

namespace App\Http\Controllers\Auth;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Models\Authimage;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    use SeoPage;

    /**
     * Display the registration view.
     */
    public function create()
    {
        $this->SeoPage('ریوو | عضویت در سایت'
            , 'عضویت در سایت ریوو'
            , 'https://rievo.ir/register'
            , 'عضویت در سایت ریوو'
            , 'ریوو | عضویت در سایت'
            , 'https://rievo.ir/register'
            , 'register'
            , 'دامداری ریوو'
            , 'ریوو | عضویت در سایت'
            , '@rievo'
            , 'ریوو | عضویت در سایت'
            , 'عضویت در سایت ریوو'
            , asset('img/logo/header_logo.svg'));
        $registerImage = Authimage::first();
        return view('auth.register', compact('registerImage'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
//
//
//    RedirectResponse
//                   |
//                   |
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'unique:' . User::class, 'max:255'],
            'mobile' => ['required', 'digits:11', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
        ]);
        $GetRequest = [
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => $request->password,
        ];
        return redirect()->route('verification.mobile', compact('GetRequest'));
    }
}
