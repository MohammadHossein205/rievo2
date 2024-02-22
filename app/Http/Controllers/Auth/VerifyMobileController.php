<?php

namespace App\Http\Controllers\Auth;

use App\HelperTrait\SendSms;
use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Models\Authimage;
use App\Models\Connecteddevices;
use App\Models\Dashboardsetting;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Cryptommer\Smsir\Smsir;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class VerifyMobileController extends Controller
{
    use SendSms, SeoPage;

    public function Verifymobile(string $mobile)
    {
        $this->SeoPage('ریوو | تایید شماره موبایل'
            , 'تایید شماره موبایل سایت ریوو'
            , 'https://rievo.ir/verify-mobile'
            , 'تایید شماره موبایل سایت ریوو'
            , 'ریوو | تایید شماره موبایل'
            , 'https://rievo.ir/verify-mobile'
            , 'verify-mobile'
            , 'دامداری ریوو'
            , 'ریوو | تایید شماره موبایل'
            , '@rievo'
            , 'ریوو | تایید شماره موبایل'
            , 'تایید شماره موبایل سایت ریوو'
            , asset('img/logo/header_logo.svg'));
        $value = $this->SendSms($mobile, 'CODE', 637540);
        $CheckMobile = true;
        $registerImage = Authimage::first();
        return view('auth.verify-mobile', compact('value', 'mobile', 'CheckMobile', 'registerImage'));
    }

    public function Verifymobile2(Request $request)
    {
        $this->SeoPage('ریوو | تایید شماره موبایل'
            , 'تایید شماره موبایل سایت ریوو'
            , 'https://rievo.ir/verify-mobile'
            , 'تایید شماره موبایل سایت ریوو'
            , 'ریوو | تایید شماره موبایل'
            , 'https://rievo.ir/verify-mobile'
            , 'verify-mobile'
            , 'دامداری ریوو'
            , 'ریوو | تایید شماره موبایل'
            , '@rievo'
            , 'ریوو | تایید شماره موبایل'
            , 'تایید شماره موبایل سایت ریوو'
            , asset('img/logo/header_logo.svg'));
        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {
            $validate = $request->validate([
                'mobile' => 'required|digits:11'
            ]);
            $mobile = $request->mobile;
            $value = $this->SendSms($mobile, 'CODE', 637540);
            $CheckMobile = true;
            $registerImage = Authimage::first();
            return view('auth.verify-mobile', compact('value', 'mobile', 'registerImage', 'CheckMobile'));
        } else {
            return back()->withErrors(['error' => 'این شماره موبایل وجود ندارد']);
        }
    }

    public function create(Request $request)
    {
        $this->SeoPage('ریوو | تایید شماره موبایل'
            , 'تایید شماره موبایل سایت ریوو'
            , 'https://rievo.ir/verify-mobile'
            , 'تایید شماره موبایل سایت ریوو'
            , 'ریوو | تایید شماره موبایل'
            , 'https://rievo.ir/verify-mobile'
            , 'verify-mobile'
            , 'دامداری ریوو'
            , 'ریوو | تایید شماره موبایل'
            , '@rievo'
            , 'ریوو | تایید شماره موبایل'
            , 'تایید شماره موبایل سایت ریوو'
            , asset('img/logo/header_logo.svg'));
        $mobile = $request->GetRequest['mobile'];
        $smsir = new Smsir(env('SMSIR_LINE_NUMBER'), env('SMSIR_API_KEY'));
        $send = $smsir::Send();
        $name = 'CODE';
        $value = Str::upper(Str::random(5));
        $parameter = new \Cryptommer\Smsir\Objects\Parameters($name, $value);
        $parameters = array($parameter);
        $send->Verify($mobile, 637540, $parameters);
        $CheckMobile = false;
        $registerImage = Authimage::first();
        return view('auth.verify-mobile', compact('request', 'mobile', 'registerImage', 'value', 'CheckMobile'));
    }

    public function store(Request $request)
    {

        $validate = $request->validate([
            'code' => 'required'
        ]);
        $code = $request->code;
        $code = Str::upper($code);
        if ($request->checkmobile == 0) {
            if ($request->value == $code) {
                $user = User::create([
                    'username' => '',
                    'name' => '',
                    'family' => '',
                    'image' => '',
                    'nationalCode' => '',
                    'mobile' => $request->mobile,
                    'homeNumber' => '',
                    'birthDate' => Carbon::now(),
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'address' => '',
                ]);
                $wallet = Wallet::create([
                    'user_id' => $user->id,
                    'money' => 0,
                ]);
                $dashboard_setting = Dashboardsetting::create([
                    'user_id' => $user->id,
                    'email_notification' => 0,
                    'new_order_accept_sms' => 0,
                    'new_order_cancel_sms' => 0,
                ]);
                $user_ip = $request->getClientIp();
//                $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
                $agent = new Agent();
                $conected = Connecteddevices::create([
                    'user_id' => $user->id,
                    'browser_name' => $agent->browser(),
                    'device' => $agent->platform(),
                    'ip' => $user_ip,
                    'user_location' => 'IRAN',
                    'status' => true,
                ]);

                event(new Registered($user));
                Auth::login($user);
                return redirect()->route('home.user.dashboard');
            } else {
                return user_error('کد صحیح نمی باشد');
            }
        } else {
            if ($request->value == $code) {
                $user = User::where('mobile', $request->mobile)->first();
//                Auth::login($user);
                Auth::loginUsingId($user->id);
                return redirect()->route('home.user.dashboard');
            } else {
                return back()->with('code', 'کد صحیح نمی باشد');
            }
        }
    }
}
