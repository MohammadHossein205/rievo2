<?php

namespace App\Http\Controllers\home;

use App\HelperTrait\CartChecker;
use App\HelperTrait\CheckFactorExpire;
use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\ArticleResource;
use App\Http\Resources\admin\ChartPriceResource;
use App\Http\Resources\admin\DamIndexResource;
use App\Http\Resources\admin\DamvizheResource;
use App\Http\Resources\admin\FaqsettingResource;
use App\Http\Resources\admin\GroupResource;
use App\Http\Resources\admin\UserIndexResource;
use App\Models\Article;
use App\Models\Chartprice;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Faqsetting;
use App\Models\Group;
use App\Models\Indexpagesetting;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\User;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class IndexContoller extends Controller
{
    use SeoPage,CheckFactorExpire, CartChecker;

    public function __construct()
    {
//        Auth::loginUsingId(1);
    }

    public function index()
    {
        $this->SeoPage('ریوو | دامداری مجازی'
            , 'خرید و فروش انواع دام های موجود به صورت آنلاین'
            , 'https://rievo.ir'
            , 'خرید و فروش انواع دام های موجود به صورت آنلاین'
            , 'ریوو | دامداری مجازی'
            , 'https://rievo.ir', 'index'
            , 'دامداری ریوو'
            , 'ریوو | دامداری مجازی'
            , '@rievo'
            , 'ریوو | دامداری مجازی'
            , 'خرید و فروش انواع دام های موجود به صورت آنلاین'
            , asset('img/logo/header_logo.svg'));
        $this->CheckFactor();
        $this->CartCheck();
        $indexSettingData = Indexpagesetting::latest()->get();
        $damData = json_encode(DamIndexResource::collection(Dam::where('status', 1)->latest()->get()));
        $favoritdamData = json_encode(DamIndexResource::collection(Dam::withCount('likes')->orderBy('likes_count', 'DESC')->get()));
        $damGroup = json_encode(GroupResource::collection(Group::latest()->get()->take(6)));
        $userData = json_encode(UserIndexResource::collection(User::latest()->where('id', '!=', 1)->get()));
        $faqData = json_encode(FaqsettingResource::collection(Faqsetting::latest()->get()));
        $articleData = json_encode(ArticleResource::collection(Article::latest()->get()->take(3)));
        $damvizheData = json_encode(DamvizheResource::collection(Damvizhe::latest()->get()));
        return view('home.index', compact('indexSettingData', 'damData', 'favoritdamData', 'damGroup', 'userData', 'faqData', 'articleData', 'damvizheData'));
    }

    public function GetGroups()
    {
        return json_encode(GroupResource::collection(Group::latest()->get()->take(6)));
    }

    public function FillChart(Request $request)
    {
        $id = $request->id;
        $chartPrice = ChartPriceResource::collection(Chartprice::where('group_id', $id)->get());
        return $chartPrice;
    }

    public function GetLastUpdate(Request $request)
    {
        $id = $request->id;
        $group = GroupResource::collection(Group::where('id', $id)->latest("updated_at")->get()->take(1));
        $chartPrice = ChartPriceResource::collection(Chartprice::where('group_id', $id)->latest()->get()->take(1));
        return $chartPrice;
    }
}
