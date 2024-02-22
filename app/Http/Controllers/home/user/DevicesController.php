<?php

namespace App\Http\Controllers\home\user;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Models\Connecteddevices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DevicesController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | دستگاه های متصل کاربر'
            , 'نمایش دستگاه های متصل کاربر'
            , 'https://rievo.ir/user/devices'
            , 'نمایش دستگاه های متصل کاربر'
            , 'ریوو | دستگاه های متصل کاربر'
            , 'https://rievo.ir/user/devices'
            , 'user/devices'
            , 'دامداری ریوو'
            , 'ریوو | دستگاه های متصل کاربر'
            , '@rievo'
            , 'ریوو | دستگاه های متصل کاربر'
            , 'نمایش دستگاه های متصل کاربر'
            , asset('img/logo/header_logo.svg'));
        $devices = Connecteddevices::where('user_id', auth()->user()->id)->get();
        return view('home.user.devices.index', compact('devices'));
    }

    public function destroy(string $id)
    {
        $connectedDevices = Connecteddevices::where('id', $id)->first();
        $connectedDevices->delete();
        return Redirect::back();
    }
}
