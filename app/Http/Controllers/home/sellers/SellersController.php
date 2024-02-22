<?php

namespace App\Http\Controllers\home\sellers;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DamIndexResource;
use App\Http\Resources\admin\GroupResource;
use App\Http\Resources\admin\UserIndexResource;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Group;
use App\Models\GroupCompany;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellersController extends Controller
{
    use SeoPage;

    public function index(string $id)
    {
        $user = UserIndexResource::collection(User::where('id', $id)->get());

        $this->SeoPage($user[0]->fullname
            , $user[0]->fullname
            , 'https://rievo.ir/sellers/' . $user[0]->fullname
            , $user[0]->fullname
            , $user[0]->fullname
            , 'https://rievo.ir/sellers/' . $user[0]->fullname
            , 'sellers'
            , 'دامداری ریوو'
            , $user[0]->fullname
            , '@rievo'
            , $user[0]->fullname
            , $user[0]->fullname
            , asset('img/logo/header_logo.svg'));
        $payments_user = Payment::where('user_id', $id)->where('status', 1)->get('id');
        $payments_buy = Payment::where('user_id', $id)->where('status', 1)->where('buyorsell', 1)->get('id');
        $payments_sell = Payment::where('user_id', $id)->where('status', 1)->where('buyorsell', 0)->get('id');

        $payments_detail = PaymentDetail::query();
        $user_dam = $payments_detail->whereIn('payment_id', $payments_user)->get('count');
        $buy_dam = $payments_detail->whereIn('payment_id', $payments_buy)->get('count');
        $sell_dam = $payments_detail->whereIn('payment_id', $payments_sell)->get('count');

        $user_dam_count = 0;
        $buy_dam_count = 0;
        $sell_dam_count = 0;
        foreach ($user_dam as $item) {
            $user_dam_count += $item->count;
        }
        foreach ($buy_dam as $item) {
            $buy_dam_count += $item->count;
        }
        foreach ($sell_dam as $item) {
            $sell_dam_count += $item->count;
        }

        $damscount = Dam::where('user_id', $id)->latest()->get();

        $damGroup = GroupResource::collection(Group::latest()->get()->take(6));

        $groupCompany = GroupCompany::latest()->get();

        $Dam = (DamIndexResource::collection(Dam::where('user_id', $id)->latest()->paginate(16)));

        $allCommentCount = DB::table('comments')
            ->where('user_id', $id)
            ->selectRaw('count(rate) as rate_count')
            ->groupBy('rate')->get();

        return view('home.seller.index', compact('user', 'damscount', 'damGroup', 'groupCompany', 'Dam', 'user_dam_count', 'buy_dam_count', 'sell_dam_count', 'allCommentCount'));
    }
}
