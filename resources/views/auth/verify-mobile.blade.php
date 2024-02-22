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
    {{--    <link rel="stylesheet" href="/css/home-c9a7208d.css">--}}
    {{--    <link rel="stylesheet" href="/css/home-d78e3e22.css">--}}
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
                <p>تایید شماره همراه</p>
                <strong>کد تایید ارسال شما به شماره موبایل خود را وارد کنید</strong>
            </div>
            {{--            {{$request->GetRequest[]}}--}}
            <form class="loginForm" method="post"
                  action="{{route('create.mobile')}}">
                @csrf
                <div class="frmInputBx mb-3 mt-5">
                    <span class="icon-Group-2300"></span>
                    <div class="position-relative">
                        <label for="inpt02" class="transitionCls"
                        >کد تایید را وارد کنید</label
                        >
                        <input type="text" name="code" id="inpt02" class="transitionCls"/>
                        @if(!$CheckMobile)
                            <input type="hidden" name="mobile" value="{{$request->GetRequest['mobile']}}"/>
                            <input type="hidden" name="email" value="{{$request->GetRequest['email']}}"/>
                            <input type="hidden" name="password" value="{{$request->GetRequest['password']}}"/>
                        @else
                            <input type="hidden" name="mobile" value="{{$mobile}}"/>
                            <input type="hidden" name="checkmobile" value="{{$CheckMobile}}"/>
                        @endif
                        <input type="hidden" name="value" value="{{$value}}"/>
                    </div>
                </div>
                @if($errors->any())
                    @error('code')
                    <div class="error">{{$message}}</div>
                    @enderror
                @else
                    <div class="error">
                        {!! session()->get('code') !!}
                    </div>
                @endif
                <div class="resendCodBx">
                    <span> کدی دریافت نکرده اید؟ </span>
                    <a href="/verify-mobile-Verifymobile/{{$mobile}}" class="transitionCls">ارسال دوباره</a>
                </div>
                <button type="submit">تایید و ساخت حساب کاربری</button>
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

{{--<script type="module" src="/js/home-b18b55df.js"></script>--}}
{{--<script type="module" src="/js/jquery.min.js"></script>--}}
{{--<script type="module" src="/js/bootstrap.min.js"></script>--}}
{{--<script type="module" src="/js/main.js"></script>--}}
{{--<script type="module" src="/js/swiper-bundle.js"></script>--}}
{{--<script type="module" src="/js/tabs.js"></script>--}}
{{--<script type="module" src="/js/chart.js"></script>--}}
{{--<script type="module" src="/js/helpers.segment-5ffe24b8.js"></script>--}}
</body>
</html>

