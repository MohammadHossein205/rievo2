<?php

namespace App\Http\Controllers\home\user;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\TicketgroupeResource;
use App\Http\Resources\home\SimpleTicketResource;
use App\Http\Resources\home\SupportResource;
use App\Models\Questionanswersetting;
use App\Models\Ticket;
use App\Models\Ticketgroupe;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | پشتیبانی'
            , 'نمایش پیام های پشتیبانی کاربر'
            , 'https://rievo.ir/user/support'
            , 'نمایش پیام های پشتیبانی کاربر'
            , 'ریوو | پشتیبانی'
            , 'https://rievo.ir/user/support'
            , 'user/support'
            , 'دامداری ریوو'
            , 'ریوو | پشتیبانی'
            , '@rievo'
            , 'ریوو | پشتیبانی'
            , 'نمایش پیام های پشتیبانی کاربر'
            , asset('img/logo/header_logo.svg'));
        $settingData = Questionanswersetting::latest()->get();
        $supportData = json_encode(SupportResource::collection(Ticketgroupe::latest()->where('user_id', auth()->id())->get()));
        return view('home.user.support.index', compact('supportData', 'settingData'));
    }

    public function SendUserTicket(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required',
            'title' => 'required',
            'body' => 'required',
        ]);

        $ticketgroup = Ticketgroupe::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
        ]);
        $ticket = Ticket::create([
            'ticketgroupe_id' => $ticketgroup->id,
            'user_id' => $request->user_id,
            'body' => $request->body,
        ]);
        if ($ticket && $ticketgroup) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    public function ShowTicketAnswer(Ticketgroupe $ticketgroupe)
    {
        $ticketgroupeid = $ticketgroupe->id;
        $ticketData = json_encode(SimpleTicketResource::collection(Ticket::where('ticketgroupe_id', $ticketgroupeid)->get()));
        $ticketGroupeData = json_encode(SupportResource::make($ticketgroupe));
        return view('home.user.showadminanswer.index', compact('ticketData', 'ticketGroupeData'));
    }
}
