@extends('home.master')
@section('content')
    <section class="walletTopSec position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="walletTopBox">
                        <div class="walletTopTxt">
                            <h1>
                                {{$text->title_text}}
                                <strong>کیف پول ریوو</strong>
                            </h1>
                            <p>
                                {{$text->title_description}}
                            </p>
                        </div>
                        <img src="{{asset('img/money.png')}}" alt="img"/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="hsbndryAbut hsbndryAbut2">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hsbndryTrait walletMb">
                        <div class="cattleTitl">
                            <span class="icon-Vector-781"></span>
                            <h2>ویژگی کیف پول ریوو</h2>
                        </div>
                        <ul>
                            <li>
                                <div class="transitionCls">
                                    <span class="icon-Group-2105"></span>
                                </div>
                                <p class="transitionCls">امنیت بالا</p>
                            </li>
                            <li>
                                <div class="transitionCls">
                                    <span class="icon-Group-2173"></span>
                                </div>
                                <p class="transitionCls">سرعت در پرداخت</p>
                            </li>
                            <li>
                                <div class="transitionCls">
                                    <span class="icon-Group-2363"></span>
                                </div>
                                <p class="transitionCls">برداشت پول</p>
                            </li>
                            <li>
                                <div class="transitionCls">
                                    <span class="icon-Group-2253"></span>
                                </div>
                                <p class="transitionCls">مدیریت هزینه ها</p>
                            </li>
                            <li>
                                <div class="transitionCls">
                                    <span class="icon-Vector-148"></span>
                                </div>
                                <p class="transitionCls">پشتیبانی</p>
                            </li>
                        </ul>
                    </div>
                    <div class="hsbndryAbtBx">
                        <span class="icon-Group-2353"></span>
                        <strong
                        >درباره <a href="#"> کیف پول ریوو </a> بیشتر بدانید</strong
                        >
                        <p>
                            {{$text->about_wallet}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="activRanch">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="ranch_bg"></div>
                    <div class="actvRanchBx">
                        <h2>همین حالا کیف پول خود را در ریوو فعال کنید</h2>
                        <div class="actvRnchLnk">
                            <a href="{{route('register')}}" class="transitionCls">
                                <span class="icon-Group-2343"></span>
                                <p>ساخت حساب کاربری</p>
                                <i class="icon-Group-2210"></i>
                            </a>
                            <a href="#" class="transitionCls">
                                <span class="icon-Vector-781"></span>
                                <p>پشتیبانی</p>
                                <i class="icon-Group-2210"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
