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
            <div class="loginTab">
                <a href="{{route('login')}}" class="active transitionCls">ورود به حساب کاربری</a>
                <a href="{{route('register')}}" class="transitionCls">ساخت حساب کاربری</a>
            </div>
            <div class="logFrmTxt">
                <p>برای استفاده از دامداری آنلاین خود،</p>
                <span>وارد حساب </span>
                <strong> کاربری شوید</strong>
            </div>
            <form class="loginForm" method="get" action="{{route('verification.Verifymobile')}}">
                @csrf
                <div class="frmInputBx mb-3">
                    <span class="icon-Vector-682"></span>
                    <div class="position-relative">
                        <label for="mobile" class="transitionCls">شماره موبایل خود را وارد کنید</label>
                        <input type="text" maxlength="11" name="mobile" id="mobile" class="transitionCls"/>
                        {{--                        <i class="icon-Group-20921 validMark"><i class="path1"></i><i class="path2"></i></i>--}}
                    </div>
                </div>
                @error('mobile')
                <div class="error">{{$message}}</div>
                @enderror
                @error('error')
                <div class="error">{{$message}}</div>
                @enderror
                <button type="submit">ثبت شماره موبایل</button>
            </form>
            <div class="loginOthrLnk">
                <div><span></span><i>یا</i><span></span></div>
                <div class="anotherLogin">
                    <a href="#" class="transitionCls">
                        <span class="icon-google-"></span>
                        <i>ورود با حساب کاربری گوگل</i>
                    </a>
                    <a href="{{route('login')}}" class="transitionCls">
                        <span class="icon-Group-2292"></span>
                        <i>ورود با ایمیل</i>
                    </a>
                </div>
            </div>
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
