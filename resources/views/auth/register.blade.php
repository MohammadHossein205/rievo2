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
        <img src="{{$registerImage->register_image}}" class="" alt="bg"/>
    </div>
    <div class="logSecLeft">
        <div class="loginFrmBx">
            <a href="/" class="logFrmLogo">
                <img src="{{asset('img/logo/header_logo.svg')}}" alt="logo" id="login_logo"/>
            </a>
            <div class="loginTab">
                <a href="{{route('login')}}" class="transitionCls">ورود به حساب کاربری</a>
                <a href="{{route('register')}}" class="active transitionCls">ساخت حساب کاربری</a>
            </div>
            <div class="logFrmTxt">
                <p>با ساخت حساب کاربری جدید،</p>
                <strong
                >میتوانید از امکانات ویژه دامداری آنلاین خود بهره مند شوید</strong
                >
            </div>
            <form class="loginForm" method="post" action="{{route('register')}}">
                @csrf
                <div class="frmInputBx mb-3">
                    <span class="icon-Group-2292"></span>
                    <div class="position-relative">
                        <label for="inpt01" class="transitionCls"
                        >ایمیل خود را وارد کنید</label
                        >
                        <input type="email" id="inpt01" value="{{old('email')}}" name="email" class="transitionCls"/>
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

                <div class="frmInputBx mb-3">
                    <span class="icon-Vector-682"></span>
                    <div class="position-relative">
                        <label for="inpt02" class="transitionCls"
                        >شماره موبایل خود را وارد کنید</label
                        >
                        <input type="text" id="inpt02" value="{{old('mobile')}}" maxlength="11" name="mobile"
                               class="transitionCls"/>
                        @error('mobile')
                        <i class="icon-valid-2 validMark"
                        ><i class="path1"></i><i class="path2"></i
                            ><i class="path3"></i
                            ></i>
                        @enderror
                    </div>
                </div>
                @error('mobile')
                <div class="error">   {{$message}}</div>
                @enderror
                <div class="frmInputBx mb-3">
                    <span class="icon-Group-2105"></span>
                    <div class="position-relative">
                        <label for="inpt03" class="transitionCls">رمز عبور خود را وارد کنید</label>
                        <input type="password" id="inpt03" name="password" class="transitionCls"/>
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
                <div class="frmInputBx mb-3">
                    <span class="icon-Group-2105"></span>
                    <div class="position-relative">
                        <label for="inpt04" class="transitionCls">تکرار رمز عبور</label>
                        <input type="password" id="inpt04" name="password_confirmation" class="transitionCls"/>
                    </div>
                </div>
                <button
                    type="button"
                    data-bs-target="#rulesMdl1"
                    data-bs-toggle="modal">
                    ساخت حساب کاربری جدید
                </button>
                <div
                    class="modal fade rulesModal"
                    id="rulesMdl1"
                    tabindex="-1"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="rulesMdlRght">
                                <div class="ruleRghtBx">
                                    <div class="ruleMdlTitle">
                                        @php($condition=\App\Models\PaymentCondition::first())
                                        <strong>سلام، کاربر گرامی</strong>
                                        <p>
                                            {{$condition->title_text}}
                                        </p>
                                    </div>
                                    <div class="ruleMdlTxt">
                                        <div>
                                            {{$condition->body_text}}
                                        </div>
                                    </div>
                                    <button
                                        type="submit"
                                        class="transitionCls"
                                        data-bs-target="#rulesMdl2"
                                        data-bs-toggle="modal"
                                    >
                                        قوانین را مطالعه کرده و قبول دارم
                                    </button>
                                </div>
                            </div>
                            <img src="{{$condition->image}}" alt="">
                        </div>
                    </div>
                </div>
            </form>
            <div class="loginOthrLnk">
                <div><span></span><i>یا</i><span></span></div>
                <div class="anotherLogin">
                    <a href="/authorized/google" class="transitionCls">
                        <span class="icon-google-"></span>
                        <i>ورود با حساب کاربری گوگل</i>
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
{{--@vite('resources/js/home/tabs.js')--}}
{{--@vite('resources/js/home/chart.js')--}}
{{--@vite('resources/js/home/persian-date.min.js')--}}
{{--@vite('resources/js/home/persian-datepicker.min.js')--}}

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

