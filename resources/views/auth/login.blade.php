<!DOCTYPE html>
<html lang="fa" id="html">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/svg" href="{{asset('img/logo/favicon.svg')}}"/>
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    {{--    <link rel="stylesheet" href="/css/home-e6d21c05.css">--}}
    {{--    <link rel="stylesheet" href="/css/home-f108c649.css">--}}
    @vite('resources/css/home.scss')
</head>
<body>
<section class="loginSec">
    <div class="loginBg">
        <img src="{{$loginImage->login_image}}" class="" alt="bg"/>
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
            <form class="loginForm" method="post" action="{{route('login')}}">
                @csrf
                <div class="frmInputBx mb-3">
                    <span class="icon-Group-2292"></span>
                    <div class="position-relative">
                        <label for="inpt01" class="transitionCls">ایمیل خود را وارد کنید</label>
                        <input type="email" name="email" value="{{old('email')}}" id="inpt01" class="transitionCls"/>
                        @error('email')
                        <i class="icon-valid-2 validMark"
                        ><i class="path1"></i><i class="path2"></i
                            ><i class="path3"></i
                            ></i>
                        @enderror
                    </div>
                </div>
                @error('email')
                <div class="error">{{$message}}</div>
                @enderror
                <a href="{{route('password.request')}}" class="forgetPass">فراموشی رمز عبور؟</a>
                <div class="frmInputBx mb-3">
                    <span class="icon-Group-2105"></span>
                    <div class="position-relative">
                        <label for="inpt02" class="transitionCls">رمز عبور خود را وارد کنید</label>
                        <input type="password" name="password" id="inpt02" class="transitionCls"/>
                        @error('password')
                        <i class="icon-valid-2 validMark"
                        ><i class="path1"></i><i class="path2"></i
                            ><i class="path3"></i
                            ></i>
                        @enderror
                    </div>
                </div>
                @error('password')
                <div class="error">{{$message}}</div>
                @enderror
                <button type="submit">ورود به حساب کاربری</button>
            </form>
            <div class="loginOthrLnk">
                <div><span></span><i>یا</i><span></span></div>
                <div class="anotherLogin">
                    <a href="/authorized/google" class="transitionCls">
                        <span class="icon-google-"></span>
                        <i>ورود با حساب کاربری گوگل</i>
                    </a>
                    <a href="/mobile-login" class="transitionCls">
                        <span class="icon-Vector-682"></span>
                        <i>ورود با موبایل</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@vite('resources/js/home/jquery.min.js')
@vite('resources/js/home/bootstrap.min.js')
@vite('resources/js/home/main.js')
@vite('resources/js/home/swiper-bundle.js')

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
