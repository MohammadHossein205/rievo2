<?php

namespace App\Http\Controllers\home\about;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Models\Aboutus;
use App\Models\Fakecomment;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | درباره ما'
            , 'دامداری آنلاین ریوو ، خرید و فروش دام به صورت آنلاین'
            , 'https://rievo.ir/about'
            , 'دامداری آنلاین ریوو ، خرید و فروش دام به صورت آنلاین'
            , 'ریوو | درباره ما'
            , 'https://rievo.ir/about'
            , 'aboutus'
            , 'دامداری ریوو'
            , 'ریوو | درباره ما'
            , '@rievo'
            , 'ریوو | درباره ما'
            , 'دامداری آنلاین ریوو ، خرید و فروش دام به صورت آنلاین'
            , asset('img/logo/header_logo.svg'));
        $aboutusData = Aboutus::latest()->get();
        $fakeCommentData = Fakecomment::latest()->get();
        return view('home.about.index', compact('aboutusData', 'fakeCommentData'));
    }
}
