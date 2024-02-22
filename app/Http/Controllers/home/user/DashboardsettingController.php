<?php

namespace App\Http\Controllers\home\user;

use App\Http\Controllers\Controller;
use App\Models\Dashboardsetting;
use Illuminate\Http\Request;

class DashboardsettingController extends Controller
{
    public function GetSetting(Request $request)
    {
        $id = $request->id;
        $setting = Dashboardsetting::where('user_id', $id)->first();
        return $setting;
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $setting = Dashboardsetting::where('user_id', $id)->first();
        $setting->update([
            'email_notification' => $request->email_notification,
            'new_order_accept_sms' => $request->new_order_accept_sms,
            'new_order_cancel_sms' => $request->new_order_cancel_sms,
        ]);
        return 200;
    }
}
