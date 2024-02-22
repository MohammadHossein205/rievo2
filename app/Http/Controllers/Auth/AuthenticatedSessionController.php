<?php

namespace App\Http\Controllers\Auth;

use App\HelperTrait\CartChecker;
use App\HelperTrait\CheckFactorExpire;
use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Authimage;
use App\Models\Connecteddevices;
use App\Models\Factor;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;


class AuthenticatedSessionController extends Controller
{
    use SeoPage, CheckFactorExpire, CartChecker;

    /**
     * Display the login view.
     */
    public function create(): View
    {
        $this->SeoPage('ریوو | ورود به سایت'
            , 'ورود در سایت ریوو'
            , 'https://rievo.ir/login'
            , 'ورود در سایت ریوو'
            , 'ریوو | ورود به سایت'
            , 'https://rievo.ir/login'
            , 'login'
            , 'دامداری ریوو'
            , 'ریوو | ورود به سایت'
            , '@rievo'
            , 'ریوو | ورود به سایت'
            , 'ورود در سایت ریوو'
            , asset('img/logo/header_logo.svg'));
        $loginImage = Authimage::first();
        return view('auth.login', compact('loginImage'));
    }

    public function mobilelogin()
    {
        $this->SeoPage('ریوو | ورود با شماره موبایل'
            , 'ورود به سایت ریوو با شماره موبایل'
            , 'https://rievo.ir/mobile-login'
            , 'ورود به سایت ریوو با شماره موبایل'
            , 'ریوو | ورود با شماره موبایل'
            , 'https://rievo.ir/login'
            , 'login-mobile'
            , 'دامداری ریوو'
            , 'ریوو | ورود با شماره موبایل'
            , '@rievo'
            , 'ریوو | ورود با شماره موبایل'
            , 'ورود به سایت ریوو با شماره موبایل'
            , asset('img/logo/header_logo.svg'));
        $registerImage = Authimage::first();
        return view('auth.mobile', compact('registerImage'));
    }


    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $agent = new Agent();
        $devices = Connecteddevices::where('user_id', auth()->user()->id)->get();
        $bool = false;
        $index = [];
        $user_ip = $request->getClientIp();
        foreach ($devices as $device) {
            if ($device->browser_name == $agent->browser() && $device->device == $agent->platform()) {
                $index = $device;
                $bool = true;
                break;
            }
        }
        foreach ($devices as $device) {
            $device->update([
                'status' => false
            ]);
        }
        if ($bool) {
            $index->update([
                'status' => true
            ]);
        } else {
            $conected = Connecteddevices::create([
                'user_id' => auth()->user()->id,
                'browser_name' => $agent->browser(),
                'device' => $agent->platform(),
                'ip' => $user_ip,
                'user_location' => 'IRAN',
                'status' => true,
            ]);
        }
        return redirect()->route('home.user.dashboard');
    }


    /**
     * Destroy an authenticated session.
     */
    public
    function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
