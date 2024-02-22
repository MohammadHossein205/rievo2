<?php

namespace App\Http\Controllers\home\contact_us;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Models\Contactus;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | تماس با ما'
            , 'با استقاده از اطلاعات تماس و ایمیل و آدرس میتوانید با ما در ارتباط باشید'
            , 'https://rievo.ir/contact_us'
            , 'با استقاده از اطلاعات تماس و ایمیل و آدرس میتوانید با ما در ارتباط باشید'
            , 'ریوو | تماس با ما'
            , 'https://rievo.ir/contact_us'
            , 'contact_us'
            , 'دامداری ریوو'
            , 'ریوو | تماس با ما'
            , '@rievo'
            , 'ریوو | تماس با ما'
            , 'با استقاده از اطلاعات تماس و ایمیل و آدرس میتوانید با ما در ارتباط باشید'
            , asset('img/logo/header_logo.svg'));
        $contactusData = Contactus::latest()->get();
        return view('home.contact_us.index', compact('contactusData'));
    }
}
