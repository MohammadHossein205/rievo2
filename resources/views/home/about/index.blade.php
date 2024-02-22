@extends('home.master')
@section('content')
    <section class="aboutTopSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @foreach($aboutusData as $aboutus)@endforeach
                    <div class="aboutTopBx">
                        <div class="abutTopInfo">
                            <div class="abutTopTxt">
                                <h1>
                                    {{$aboutus->big_title}}
                                </h1>
                                <strong>{{$aboutus->small_title}}</strong>
                                <p>
                                    {{$aboutus->big_text}}
                                </p>
                            </div>
                            <ul class="abutTopNum">
                                <li>
                                    <strong>{{\App\Models\User::count()}}</strong>
                                    <span>دام دار فعال</span>
                                </li>
                                <li>
                                    <strong>{{\App\Models\Payment::where('status',1)->count()}}</strong>
                                    <span>تراکنش موفق</span>
                                </li>
                            </ul>
                            <div class="abtTopRnchr">
                                <p>برخی از دامداران</p>
                                <ul>
                                    @php($user_id=\App\Models\Dam::get('user_id'))
                                    @foreach(\App\Models\User::whereIn('id',$user_id)->get()->take(6) as $user)
                                        <li>
                                            <a href="/sellers/{{$user->id}}" class="transitionCls">
                                                <img src="{{$user->image}}" alt="img"/>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="abutTopImg">
                            <img src="{{$aboutus->image}}" alt="img"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="aboutBtmSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="aboutMore">
                        <span class="icon-Group-2353"></span>
                        <strong>درباره <i>ریوو</i> بیشتر بدانید</strong>
                        <p>
                            {{$aboutus->about_text}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="aboutSlider">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cattleTitl">
                            <span class="icon-Vector-781"></span>
                            <h2>نظرات برخی از دامداران فعال در ریوو</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($fakeCommentData as $fakecomment)
                        <div class="swiper-slide transitionCls">
                            <div class="abtSwprCrd transitionCls">
                                <div class="abtCrdHed position-relative">
                                    <div class="abtCrdUser">
                                        <img src="{{$fakecomment->image}}" alt="{{$fakecomment->namefamily}}"/>
                                        <div>
                                            <strong>{{$fakecomment->namefamily}}</strong>
                                            {{--                                            <p>زارا</p>--}}
                                        </div>
                                    </div>
                                    <img src="{{asset('img/quote.svg')}}" class="quoteImg" alt="img"/>
                                </div>
                                <div class="abtCrdBdy">
                                    {{$fakecomment->body}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="aboutQuestn">
                        <span class="icon-Group-2272"></span>
                        <strong>سوالی ذهن شما را درگیره کرده است؟</strong>
                        <div>تیم پشتیبانی ریوو آماده پاسخ به سوالات شماست</div>
                        <a href="{{route('home.contact_us')}}" class="transitionCls">
                            <i class="icon-Vector-781"></i>
                            <p>ارتباط با ما</p>
                            <small class="icon-Group-2210 transitionCls"></small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
