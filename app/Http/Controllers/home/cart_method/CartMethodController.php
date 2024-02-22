<?php

namespace App\Http\Controllers\home\cart_method;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;

class CartMethodController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | پرداخت سبد خرید'
            , 'پرداخت سبد خرید'
            , 'https://rievo.ir/user/pay/dam'
            , 'پرداخت سبد خرید'
            , 'ریوو | پرداخت سبد خرید'
            , 'https://rievo.ir/user/pay/dam'
            , 'user/pay/dam'
            , 'دامداری ریوو'
            , 'ریوو | پرداخت سبد خرید'
            , '@rievo'
            , 'ریوو | پرداخت سبد خرید'
            , 'پرداخت سبد خرید'
            , asset('img/logo/header_logo.svg'));
        return view('home.cart_method.index');
    }
}
