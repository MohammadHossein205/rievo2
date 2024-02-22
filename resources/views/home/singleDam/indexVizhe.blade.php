@extends('home.master')
@section('content')
    @php($dam=json_decode($damData))
    @php($damSame=json_decode($sameDam))
    <section class="breadcrumbSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul>
                        <li><a href="{{route('home.shop')}}" class="transitionCls">فروشگاه</a></li>
                        <li>
                            <span>/</span>
                        </li>
                        <li><a href="#" class="transitionCls">
                                {{$dam->group_id}}
                            </a></li>
                        <li>
                            <span>/</span>
                        </li>
                        <li>
                            <a href="#" class="transitionCls">
                                {{$dam->name}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="prodctPgSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="prodctPgBx">
                        <div class="prdctPgSldr">
                            {{--                            <div class="swiper AdSwiper2">--}}
                            {{--                                <div class="swiper-wrapper">--}}
                            {{--                                    <div class="swiper-slide">--}}
                            {{--                                        @foreach($dam->image as $item)--}}
                            {{--                                            @if($loop->iteration==1)--}}
                            {{--                                                <img src="{{$item->url}}" alt="{{$dam->name}}"/>--}}
                            {{--                                            @endif--}}
                            {{--                                        @endforeach--}}
                            {{--                                        <div class="shopTopLnks">--}}
                            {{--                                            <buy-dam :user="{{auth()->user()}}" :dam="{{$damData}}" type="vizhe"--}}
                            {{--                                                     :text="true"--}}
                            {{--                                                     :arrow="true"></buy-dam>--}}
                            {{--                                            <btn-like :like="{{json_encode(hasLike($dam->id,$dam->model_type))}}"--}}
                            {{--                                                      :id="{{json_encode($dam->id)}}"--}}
                            {{--                                                      :type="{{json_encode($dam->model_type)}}"></btn-like>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                    @foreach($dam->image as $item)--}}
                            {{--                                        @if($loop->iteration!=1)--}}
                            {{--                                            <div class="swiper-slide">--}}
                            {{--                                                <img src="{{$item->url}}" alt="{{$dam->name}}"/>--}}
                            {{--                                            </div>--}}
                            {{--                                        @endif--}}
                            {{--                                    @endforeach--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div thumbsSlider="" class="swiper AdSwiper1">--}}
                            {{--                                <div class="swiper-wrapper">--}}
                            {{--                                    @foreach($dam->image as $item)--}}
                            {{--                                        <div class="swiper-slide">--}}
                            {{--                                            <img src="{{$item->url}}" alt="{{$dam->name}}"/>--}}
                            {{--                                        </div>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <single-dam-slider :damimage="{{json_encode($dam->image)}}"
                                               :dam="{{json_encode($dam)}}"
                            >
                                <div class="shopTopLnks">
                                    @if(auth()->user())
                                        <buy-dam :user="{{auth()->user()}}" :dam="{{$damData}}" :text="true"
                                                 :arrow="true" type="vizhe"></buy-dam>
                                    @else
                                        <buy-dam user="" :dam="{{$damData}}" :text="true"
                                                 :arrow="true" type="vizhe"></buy-dam>
                                    @endif
                                    <btn-like :like="{{json_encode(hasLike($dam->id,$dam->model_type))}}"
                                              :id="{{json_encode($dam->id)}}"
                                              :type="{{json_encode($dam->model_type)}}"></btn-like>
                                </div>
                            </single-dam-slider>
                        </div>
                        <div class="prdctPgInfo">
                            <h1>{{ $dam->name }}</h1>
                            <div class="shopTopFee">
                                <div class="shopTopTime">
                                    <p>فروش ویژه</p>
                                    <strong class="count_down"
                                            giveDate="{{\Carbon\Carbon::parse($dam->disount_time_defult)->format('Y')}}, {{\Carbon\Carbon::parse($dam->disount_time_defult)->format('m')}},{{\Carbon\Carbon::parse($dam->disount_time_defult)->format('d')}} ">
                                        <span class="two"></span>
                                        و
                                        <span class="one"></span>
                                    </strong>
                                    <span>زمان باقی مانده</span>
                                </div>
                                <hr/>
                                <div class="shopTopPric">
                                    <span>قیمت</span>
                                    <strong class="position-relative">
                                        <img src="{{asset('img/toman.png')}}" alt="img"/>
                                        {{ $dam->disount_price }}
                                    </strong>
                                    <p class="position-relative">{{$dam->price}}</p>
                                </div>
                            </div>
                            <h2>مشخصات دام</h2>
                            <ul>
                                <li>
                                    <span>نژاد</span>
                                    <div>
                                        <p>{{ $dam->group_company_id }}</p>
                                        <i class="orange">
                                            {{$dam->group_english}}
                                        </i>
                                    </div>
                                </li>
                                <li>
                                    <span>وزن</span>
                                    <div>
                                        <p>
                                            <span>{{ $dam->weight }}</span>
                                            کیلوگرم
                                        </p>
                                        <i class="orange">KG</i>
                                    </div>
                                </li>
                                <li>
                                    <span>رنگ پوست</span>
                                    <div>
                                        <p>{{ $dam->color }}</p>
                                        <i class="orange">{{$dam->colorenglish}}</i>
                                    </div>
                                </li>
                                <li>
                                    <span>سن</span>
                                    <div>
                                        <p>
                                            <span>{{ $dam->ageYear }}</span>
                                            سال
                                            <span>{{ $dam->ageMonth }}</span>
                                            ماه
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <span>جنسیت</span>
                                    <div>
                                        <p>{{ $dam->gender }}</p>
                                    </div>
                                </li>
                                <li>
                                    <span>نوع</span>
                                    <div>
                                        <p>{{$dam->haveMilk}}</p>
                                    </div>
                                </li>
                                <li>
                                    <span> تولید شیر </span>
                                    <div>
                                        <p>{{$dam->milk_amount}} کیلوگرم</p>
                                        <i class="green">روزانه</i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="prdctSeller">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="prdctSelrBx">
                        <div class="prdctSlrRght">
                            <div class="prdctSlrTtl">
                                <span class="icon-Vector-781"></span>
                                <p>فروشنده دام</p>
                            </div>
                            <div class="prdctSlrUser">
                                <img src="{{$user->image}}" alt="{{$user->fullname}}"/>
                                <div>
                                    <strong>{{$user->fullname}}</strong>
                                    <p>{{$userDamCount}} محصول</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="exprtChkSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shopCatTtl">
                        <span class="icon-Vector-781"></span>
                        <strong>بررسی تخصصی دام</strong>
                    </div>
                    <div class="exprtChkTxt">
                        <div class="mt-5 mb-4">
                            <p>
                                {!! $dam->description !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabBox">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="tabBXHeader smMnuTbLinks">
                            <ul>
                                <li>
                                    <a
                                        href="#"
                                        class="tablinks active transitionCls"
                                        tabId="tabOne"
                                        id="defaultOpen"
                                    >نظرات کاربران و دامداران
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="tablinks transitionCls" tabId="tabTwo"
                                    >پرسش و پاسخ</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="exprtChkTab">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div id="tabOne" class="tabcontent">
                                <div class="exprtChkCmnt">
                                    <div class="xprtCmntRght">
                                        <form-comment :id="{{json_encode($dam->id)}}"
                                                      :type="{{json_encode(\App\Models\Dam::class)}}"></form-comment>
                                        {{--                                        <div id="targetElOne"></div>--}}
                                        <div class="xprtCmntList">
                                            <ul>
                                                <list-comments :id="{{json_encode($dam->id)}}"
                                                               :type="{{json_encode(\App\Models\Dam::class)}}"></list-comments>
                                            </ul>

                                        </div>
                                    </div>
                                    <rate-range-component
                                        :allcommentcount="{{json_encode($allCommentCount)}}"></rate-range-component>
                                </div>
                            </div>
                            <div id="tabTwo" class="tabcontent">
                                <div class="xportQuestn">
                                    <form-question-answer :id="{{json_encode($dam->id)}}"
                                                          :type="{{json_encode(\App\Models\Dam::class)}}"></form-question-answer>
                                    <div class="xprtQsLeft">
                                        <p>نکات مهم در ارسال پرسش</p>
                                        <ul>
                                            @foreach($questionAnswerSettingData as $questionanswersetting)
                                                <li class="position-relative">{{$questionanswersetting->text}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="xportQsList">
                                    <ul>
                                        <li>
                                            <list-question-answers :id="{{json_encode($dam->id)}}"
                                                                   :type="{{json_encode(\App\Models\Dam::class)}}">

                                            </list-question-answers>
                                        </li>

                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="newCattle">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shopCatTtl">
                        <span class="icon-Vector-781"></span>
                        <strong>دام های مشابه</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="newCatSldr">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($damSame as $same)
                        <div class="swiper-slide transitionCls">
                            <a href="/single/dam/{{$same->slug}}" class="newCatCard position-relative">
                                <div class="newCatImg">
                                    @foreach($same->image as $item)
                                        @if($loop->iteration==1)
                                            <img src="{{$item->url}}" alt="{{$same->name}}"/>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="newCatBdy">
                                    <h2>{{$same->name}}</h2>
                                    <ul>
                                        <li>
                                            <span>نژاد </span>
                                            <p>{{$same->group_id}}</p>
                                        </li>
                                        <li>
                                            <span>سن</span>
                                            <p>{{$same->ageYear}} سال {{$same->ageMonth}} ماه</p>
                                        </li>
                                        <li>
                                            <span>جنسیت</span>
                                            <p>{{$same->gender}}</p>
                                        </li>
                                    </ul>
                                    <div class="newCatbottm">
                                        <div class="newCatLike">
                                            <span class="icon-Group-2108 transitionCls"></span>
                                            <span class="icon-Group-2271 transitionCls"></span>
                                        </div>
                                        <div class="newCatPrice">
                                            <p>قیمت</p>
                                            <strong class="position-relative">
                                                <img src="{{asset('img/toman.png')}}" alt="img"/>
                                                {{$same->price}}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
