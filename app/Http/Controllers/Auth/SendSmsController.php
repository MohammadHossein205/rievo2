<?php

namespace App\Http\Controllers\Auth;

use App\HelperTrait\SendSms;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendSmsController extends Controller
{
    use SendSms;

    public function SendSmsData(Request $request)
    {
        $validate = $request->validate([
            'mobile' => 'required|digits:11'
        ]);
        $mobile = $request->mobile;
        $value = $this->SendSms($mobile, 'CODE', 637540);
        return $value;
    }
}
