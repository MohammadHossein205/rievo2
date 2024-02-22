<?php

namespace App\Http\Controllers\home\user;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | پیام های کاربر'
            , 'نمایش پیام های کاربر'
            , 'https://rievo.ir/user/notification'
            , 'نمایش پیام های کاربر'
            , 'ریوو | پیام های کاربر'
            , 'https://rievo.ir/user/notification'
            , 'user/notification'
            , 'دامداری ریوو'
            , 'ریوو | پیام های کاربر'
            , '@rievo'
            , 'ریوو | پیام های کاربر'
            , 'نمایش پیام های کاربر'
            , asset('img/logo/header_logo.svg'));
        $messageData = json_encode(MessageResource::collection(Message::where('user_id', Auth::id())->latest()->get()));
        return view('home.user.notification.index', compact('messageData'));
    }

    public function SetMessageStatus(Request $request)
    {
        $message = Message::where('id', $request->id)->first();
        $message->update([
            'is_new' => 0
        ]);
        return 200;
    }
}
