<?php

namespace App\Http\Controllers\home\husbandry;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\FaqsettingResource;
use App\Models\Faqsetting;
use App\Models\HusbandryText;

class HusbandryController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('دامداری | ریوو'
            , 'خرید و فروش انواع دام های موجود به صورت آنلاین'
            , 'https://rievo.ir/husbandry'
            , 'خرید و فروش انواع دام های موجود به صورت آنلاین'
            , 'دامداری - ریوو'
            , 'https://rievo.ir/husbandry'
            , 'husbandry'
            , 'دامداری ریوو'
            , 'دامداری - ریوو'
            , '@rievo'
            , 'دامداری - ریوو'
            , 'خرید و فروش انواع دام های موجود به صورت آنلاین'
            , asset('img/logo/header_logo.svg'));
        $faqData = json_encode(FaqsettingResource::collection(Faqsetting::latest()->get()));
        $text = HusbandryText::first();
        return view('home.husbandry.index', compact('faqData', 'text'));
    }
}
