<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/svg" href="{{asset('img/logo/favicon.svg')}}"/>
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    @vite('resources/css/home.scss')
</head>
<body>
<section class="loginSec">
    <div class="loginBg">
        <img src="{{$registerImage->login_image}}" class="" alt="bg"/>
    </div>
    <div class="logSecLeft">
        <div class="loginFrmBx">
            <a href="/" class="logFrmLogo">
                <img src="{{asset('img/logo/header_logo.svg')}}" alt="logo" id="login_logo"/>
            </a>
            <div class="marginClass"></div>
            <div class="logFrmTxt">
                <p>تایید کد بازیابی رمز عبور</p>
                <strong
                >کد تایید ارسال شما به شماره موبایل یا ایمیل خود را وارد
                    کنید</strong
                >
            </div>
            <form class="loginForm" method="post" action="{{route('change.mobile.password')}}">
                @csrf
                <div class="frmInputBx mb-3 mt-5">
                    <span class="icon-Group-2300"></span>
                    <div class="position-relative">
                        <label for="inpt02" class="transitionCls"
                        >کد تایید را وارد کنید</label
                        >
                        <input type="text" name="code" id="inpt02" class="transitionCls"/>
                        <input type="hidden" name="value" value="{{$value}}" id="inpt02" class="transitionCls"/>
                        <input type="hidden" name="mobile" value="{{$mobile}}" id="inpt02" class="transitionCls"/>
                    </div>
                </div>
                <div class="error">
                    {!! session()->get('code') !!}
                </div>
                <div class="resendCodBx">
                    <span> کدی دریافت نکرده اید؟ </span>
                    <a href="resend-mobile-value/{{$mobile}}" class="transitionCls">ارسال دوباره</a>
                </div>
                <button>تایید و ثبت رمز عبور جدید</button>
            </form>
        </div>
    </div>
</section>
@vite('resources/js/home/jquery.min.js')
@vite('resources/js/home/bootstrap.min.scss')
@vite('resources/js/home/main.js')
@vite('resources/js/home/swiper-bundle.js')
@vite('resources/js/home/tabs.js')
@vite('resources/js/home/chart.js')
@vite('resources/js/home/persian-date.min.js')
@vite('resources/js/home/persian-datepicker.min.js')
</body>
</html>

