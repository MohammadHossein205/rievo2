<?php

namespace App\Http\Controllers\home\user;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\UserIndexResource;
use App\Models\Dashboardsetting;
use App\Models\Payment;
use App\Models\PaymentCondition;
use App\Models\PaymentDetail;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserDashboard extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | پروفایل کاربری'
            , 'نمایش پروفایل کاربری'
            , 'https://rievo.ir/user/dashboard'
            , 'نمایش پروفایل کاربری'
            , 'ریوو | پروفایل کاربری'
            , 'https://rievo.ir/user/dashboard'
            , 'dashboard'
            , 'دامداری ریوو'
            , 'ریوو | پروفایل کاربری'
            , '@rievo'
            , 'ریوو | پروفایل کاربری'
            , 'نمایش پروفایل کاربری'
            , asset('img/logo/header_logo.svg'));
//        $serv = $_SERVER['HTTP_USER_AGENT'];
//        return explode(' ', $serv);
        $id = auth()->user()->id;

        $payments_user = Payment::where('user_id', $id)->where('status', 1)->where('IsMonthly', 0)->get('id');
        $payments_buy = Payment::where('user_id', $id)->where('status', 1)->where('buyorsell', 1)->where('IsMonthly', 0)->get('id');
        $payments_sell = Payment::where('user_id', $id)->where('status', 1)->where('buyorsell', 0)->where('IsMonthly', 0)->get('id');


        $setting = Dashboardsetting::where('user_id', $id)->first();
        $money = Wallet::where('user_id', $id)->first();


//        $sell_id = [];
//        for ($i = 0; $i < count($payments_sell); $i++) {
//            $sell_id[$i] = $payments_sell[$i]->id;
//        }
        $payments_detail = PaymentDetail::query();
        $user_dam = $payments_detail->whereIn('payment_id', $payments_user)->get('count');
        $buy_dam = $payments_detail->whereIn('payment_id', $payments_buy)->get('count');
        $payments_detail2 = PaymentDetail::query();
        $sell_dam = $payments_detail2->whereIn('payment_id', $payments_sell)->get('count');
        $user_dam_count = 0;
        $sell_dam_count = 0;
        $buy_dam_count = 0;
        foreach ($user_dam as $item) {
            $user_dam_count += $item->count;
        }
        foreach ($sell_dam as $item) {
            $sell_dam_count += $item->count;
        }
        foreach ($buy_dam as $item) {
            $buy_dam_count += $item->count;
        }

        $user = auth()->user();
        $birthDate = verta($user->birthDate)->formatDate();
        return view('home.user.index', compact('setting', 'money', 'birthDate', 'user', 'user_dam_count', 'sell_dam_count', 'buy_dam_count', 'buy_dam', 'sell_dam', 'user_dam'));
    }

    public function update(Request $request)
    {
        $birthDateSplit = explode($request->birthDate[4] == '-' ? '-' : '/', $request->birthDate);
        $birthDateArr = Verta::jalaliToGregorian($birthDateSplit[0], $birthDateSplit[1], $birthDateSplit[2]);
        $birthDate = $birthDateArr[0] . '-' . $birthDateArr[1] . '-' . $birthDateArr[2];
        $image = $request->file('image');
        $url = '';
        $changename = '';
        if ($image) {
            $name = $image->getClientOriginalName();
            $format = $image->getClientOriginalExtension();
            $changename = rand(1, 999999) . $name;
            $url = '/upload/image';
            $path = $_SERVER['DOCUMENT_ROOT'] . $url;
            $final = $image->move($path, $changename);
        }
        $user = User::where('id', $request->id)->first();
        if ($request->NewPassword != '') {
            if (Hash::check($request->CurrentPassword, auth()->user()->password)) {
                $request->validate([
                    'NewPassword' => 'required'
                ]);
                $user->update([
                    'password' => $request->NewPassword,
                    'changed_password' => Carbon::now(),
                ]);
            } else
                return 400;
        }
        if ($url != '')
            $user->update([
                'address' => $request->address,
                'birthDate' => $birthDate,
                'email' => $request->email,
                'fullname' => $request->fullName,
                'homeNumber' => $request->homeNumber,
                'image' => $url . '/' . $changename,
                'mobile' => $request->mobile,
                'nationalCode' => $request->nationalCode,
                'username' => $request->username,
            ]);
        else
            $user->update([
                'address' => $request->address,
                'birthDate' => $birthDate,
                'email' => $request->email,
                'fullname' => $request->fullName,
                'homeNumber' => $request->homeNumber,
                'mobile' => $request->mobile,
                'nationalCode' => $request->nationalCode,
                'username' => $request->username,
            ]);
        return 200;
    }
}
