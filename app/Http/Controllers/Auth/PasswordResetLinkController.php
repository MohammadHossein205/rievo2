<?php

namespace App\Http\Controllers\Auth;

use App\HelperTrait\SendSms;
use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Models\Authimage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    use SendSms, SeoPage;

    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        $this->SeoPage('ریوو | تایید شماره موبایل'
            , 'تایید شماره موبایل'
            , 'https://rievo.ir/forgot-password'
            , 'تایید شماره موبایل'
            , 'ریوو | تایید شماره موبایل'
            , 'https://rievo.ir/forgot-password'
            , 'forgot-password'
            , 'دامداری ریوو'
            , 'ریوو | تایید شماره موبایل'
            , '@rievo'
            , 'ریوو | تایید شماره موبایل'
            , 'تایید شماره موبایل'
            , asset('img/logo/header_logo.svg'));
        $registerImage = Authimage::first();
        return view('auth.mobile-password',compact('registerImage'));
    }

    public function sendmobilesms(Request $request)
    {
        $this->SeoPage('ریوو | تایید بازیابی رمز'
            , 'تایید بازیابی رمز'
            , 'https://rievo.ir/send-mobile-sms'
            , 'تایید بازیابی رمز'
            , 'ریوو | تایید بازیابی رمز'
            , 'https://rievo.ir/send-mobile-sms'
            , 'send-mobile-sms'
            , 'دامداری ریوو'
            , 'ریوو | تایید بازیابی رمز'
            , '@rievo'
            , 'ریوو | تایید بازیابی رمز'
            , 'تایید بازیابی رمز'
            , asset('img/logo/header_logo.svg'));
        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {
            $validate = $request->validate([
                'mobile' => 'required|digits:11'
            ]);
            $mobile = $request->mobile;
            $value = $this->SendSms($mobile, 'CODE', 637540);
            $registerImage = Authimage::first();
            return view('auth.forgot-password', compact('value', 'mobile', 'registerImage'));
        } else {
            return back()->withErrors(['error' => 'این شماره موبایل وجود ندارد']);
        }
    }

    public function Verifymobile(string $mobile)
    {
        $value = $this->SendSms($mobile, 'CODE', 637540);
        $CheckMobile = true;
        $registerImage = Authimage::first();
        return view('auth.verify-mobile', compact('value', 'mobile', 'CheckMobile'));
    }

    public function changemobilepassword(Request $request)
    {
        $code = Str::upper($request->code);
        $value = Str::upper($request->value);
        $mobile = $request->mobile;
        if ($code != $value)
            return back()->with('code', 'کد نادرست  است');
        else
            return redirect()->route('change.password', compact('mobile'));
//            return redirect()->route('change.mobile.password')->withErrors('code', 'کد نادرست است');
//        return $code;
    }

    public function resetpassword(Request $request)
    {
        $validate = $request->validate([
            'password' => 'required|confirmed'
        ]);
        $mobile = $request->mobile;
        $user = User::where('mobile', $mobile)->first();
        if ($user) {
            $user->update([
                'password' => $request->password,
            ]);
            return redirect()->route('login');
        } else {
            return back()->with('mobile', 'شماره شما ثبت نشده');
        }
    }

    public function changepassword(Request $request)
    {
        $this->SeoPage('ریوو | تغییر رمز عبور'
            , 'تغییر رمز عبور'
            , 'https://rievo.ir/change-password'
            , 'تغییر رمز عبور'
            , 'ریوو | تغییر رمز عبور'
            , 'https://rievo.ir/change-password'
            , 'change-password'
            , 'دامداری ریوو'
            , 'ریوو | تغییر رمز عبور'
            , '@rievo'
            , 'ریوو | تغییر رمز عبور'
            , 'تغییر رمز عبور'
            , asset('img/logo/header_logo.svg'));
        $mobile = $request->mobile;
        $registerImage = Authimage::first();
        return view('auth.reset-password', compact('mobile','registerImage'));
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
