@extends('home.master')
@section('content')
    @php($damGroupData=json_decode($damGroup))
    @php($damItemData=json_decode($damData))
    @php($favoritItem=json_decode($favoritdamData))
    @php($user=json_decode($userData))
    @php($faq=json_decode($faqData))
    @php($article=json_decode($articleData))
    @php($damvizhe=json_decode($damvizheData))
    <section class="landTopSec position-relative">
        {{--        <a href="{{url('/admin/payment',100000)}}">slm</a>--}}
        @foreach($indexSettingData as $indexsetting) @endforeach
        <img
            src="{{asset('img/opening_smile 3.svg')}}"
            class="homeVector homeVector1"
            alt="vector"
        />
        <img
            src="{{asset('img/opening_smile 2.svg')}}"
            class="homeVector homeVector2"
            alt="vector"
        />
        <img
            src="{{asset('img/opening_smile 4.svg')}}"
            class="homeVector homeVector3"
            alt="vector"
        />
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="landTopTxt position-relative">
                        <h1 class="position-relative">
                            {{$indexsetting->top_big_text}}
                        </h1>
                        <div class="lndTopSmall">{{$indexsetting->top_small_text}}</div>
                        <p class="landTopPar">
                            {{$indexsetting->top_big_description}}
                        </p>
                        <div class="lndTopLinks">
                            <a href="{{route('home.shop')}}" class="transitionCls btnView">
                                <i class="icon-Group-2343"></i>
                                <p>مشاهده</p>
                                <span class="icon-Group-2210"></span>
                            </a>
                            @if(auth()->user())
                                <a href="{{route('home.user.support')}}" class="transitionCls">
                                    <i class="icon-Vector-781"></i>
                                    <p>استعلام و پشتیبانی</p>
                                    <span class="icon-Group-2210"></span>
                                </a>
                            @else
                                <a href="#inquiry" class="transitionCls">
                                    <i class="icon-Vector-781"></i>
                                    <p>استعلام و پشتیبانی</p>
                                    <span class="icon-Group-2210"></span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lndTopSldr">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($damvizhe as $damvizheitem)
                        @if($damvizheitem->status==1)
                            <a href="{{route('home.single.damvizhe',$damvizheitem->slug)}}" class="swiper-slide">
                                <div class="swiperCard position-relative">
                                    <div class="hdrSwprBdy">
                                        <div class="lndSldrTFee">
                                            <div class="hdrSwprTime">
                                                <p>فروش ویژه</p>
                                                <strong class="count_down"
                                                        giveDate="{{\Carbon\Carbon::parse($damvizheitem->disount_time_defult)->format('Y')}}, {{\Carbon\Carbon::parse($damvizheitem->disount_time_defult)->format('m')}},{{\Carbon\Carbon::parse($damvizheitem->disount_time_defult)->format('d')}} ">
                                                    <span class="two"></span>
                                                    و
                                                    <span class="one"></span>
                                                </strong>
                                                <i>زمان باقی مانده</i>
                                            </div>
                                            <hr/>
                                            <div class="hdrSwprPric">
                                                <span>قیمت</span>
                                                <strong class="position-relative">
                                                    <img src="{{asset('img/toman.png')}}" alt="img"/>
                                                    {{$damvizheitem->disount_price}}
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="hdrSwprTtl">
                                            <h2>{{$damvizheitem->name}}</h2>
                                            <ul>
                                                <li>
                                                    <span> نژاد </span>
                                                    <div>
                                                        <p>{{$damvizheitem->group_company_id}}</p>
                                                        <i class="orange">{{$damvizheitem->group_english}}</i>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>وزن</span>
                                                    <div>
                                                        <p>{{$damvizheitem->weight}} کیلوگرم</p>
                                                        <i class="orange">KG</i>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>رنگ پوست</span>
                                                    <div>
                                                        <p>{{$damvizheitem->color}}</p>
                                                        <i class="orange">{{$damvizheitem->colorenglish}}</i>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>سن</span>
                                                    <div>
                                                        <p>{{$damvizheitem->ageYear}} سال {{$damvizheitem->ageMonth}}
                                                            ماه</p>
                                                        <i></i>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>جنسیت</span>
                                                    <div>
                                                        <p>{{$damvizheitem->gender}}</p>
                                                        <i></i>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>نوع</span>
                                                    <div>
                                                        <p>{{$damvizheitem->haveMilk}}</p>
                                                        <i></i>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>تولید شیر</span>
                                                    <div>
                                                        <p>{{$damvizheitem->milk_amount}} کیلوگرم</p>
                                                        <i class="green">روزانه</i>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="image_parent position-relative">
                                        @foreach($damvizheitem->image as $item)
                                            @if($loop->iteration==1)
                                                <img src="{{$item->url}}" class="position-relative"
                                                     alt="{{$damvizheitem->name}}"/>
                                            @endif
                                        @endforeach

                                        <div class="hdrSwprLnks">
                                            <button class="swprAddBtn transitionCls">
                                                <span class="icon-Group-2108"></span>
                                                <p>اضافه کردن به سبد خرید</p>
                                                <i class="icon-Group-2210"></i>
                                            </button>
                                            <button class="swprLikBtn transitionCls">
                                                <span class="icon-Group-2271"></span>
                                            </button>
                                            {{--                                        <btn-like--}}
                                            {{--                                            :like="{{json_encode(hasLike($indexsetting->id,$indexsetting->model_type))}}"--}}
                                            {{--                                            :id="{{json_encode($indexsetting->id)}}"--}}
                                            {{--                                            :type="{{json_encode($indexsetting->model_type)}}">--}}
                                            {{--                                        </btn-like>--}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cattleSec position-relative">
                        <img
                            src="{{asset('img/top-slider-lines.png')}}"
                            class="linesVector linesVector1"
                            alt="vector"
                        />
                        <div class="cattleSecBx position-relative">
                            <div class="cattleTitl">
                                <span class="icon-Vector-781"></span>
                                <h2>دسته بندی دام ها</h2>
                            </div>
                            <div class="cattleBdy">
                                @foreach($damGroupData as $damgroup)
                                    <a href="/shop/{{$damgroup->name}}"
                                       class="cattleBx position-relative transitionCls">
                                        <img
                                            src="{{$damgroup->image}}"
                                            class="position-relative"
                                            alt="img"
                                        />
                                        <div class="cattleBxCvr">
                                            <strong>{{$damgroup->name}}</strong>
                                            <p>
                                                {{$damgroup->dam_count}}
                                                <span> محصول </span>
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="newCattle">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cattleTitl">
                            <span class="icon-Vector-781"></span>
                            <h2>جدیدترین دام ها</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="newCatSldr">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($damItemData as $damdata)
                            @if($damdata->status==1)
                                <div class="swiper-slide transitionCls">
                                    <a href="{{route('home.single.dam',$damdata->slug)}}"
                                       class="newCatCard position-relative">
                                        <div class="newCatImg">
                                            @foreach($damdata->image as $item)
                                                @if($loop->iteration==1)
                                                    <img src="{{$item->url}}" alt="{{$damdata->name}}"/>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="newCatBdy">
                                            <h2>{{$damdata->name}}</h2>
                                            <ul>
                                                <li>
                                                    <span>نژاد </span>
                                                    <p>{{$damdata->group_company_id}}</p>
                                                </li>
                                                <li>
                                                    <span>سن</span>
                                                    <p>
                                                        {{$damdata->ageYear}}
                                                        <span>سال</span>
                                                        {{$damdata->ageMonth}}
                                                        <span>ماه</span>
                                                    </p>
                                                </li>
                                                <li>
                                                    <span>جنسیت</span>
                                                    <p>{{$damdata->gender}}</p>
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
                                                        {{$damdata->price}}
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="feeInquirySec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cattleTitl">
                        <span class="icon-Vector-781"></span>
                        <h2>استعلام قیمت دام</h2>
                    </div>
                    <div class="feeInquryTxt">
                        {{$indexsetting->estelam_text}}
                    </div>
                    <chart-component></chart-component>
                </div>
            </div>
        </div>
    </section>

    <section class="popularSec position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="homBaner homBnerOne position-relative">
                        <img
                            src="{{asset('img/green-banner.png')}}"
                            class="linesVector linesVector2"
                            alt="vector"
                        />
                        <a href="{{$indexsetting->baner_one_image_link}}" class="position-relative">
                            <img src="{{$indexsetting->baner_one_image}}" alt="img"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="newCattle">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cattleTitl">
                            <span class="icon-Vector-781"></span>
                            <h2>محبوب ترین ها</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="newCatSldr">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($favoritItem as $favoritdata)
                            <div class="swiper-slide transitionCls">
                                @if($favoritdata->status==1)
                                    <a href="{{route('home.single.dam',$favoritdata->slug)}}"
                                       class="newCatCard position-relative">
                                        <div class="newCatImg">
                                            @foreach($favoritdata->image as $item)
                                                @if($loop->iteration==1)
                                                    <img src="{{$item->url}}" alt="{{$damdata->name}}"/>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="newCatBdy">
                                            <h2>{{$favoritdata->name}}</h2>
                                            <ul>
                                                <li>
                                                    <span>نژاد </span>
                                                    <p>
                                                        {{$favoritdata->group_company_id}}
                                                    </p>
                                                </li>
                                                <li>
                                                    <span>سن</span>
                                                    <p>
                                                        {{$favoritdata->ageYear}}
                                                        <span>سال</span>
                                                        {{$favoritdata->ageMonth}}
                                                        <span>ماه</span>
                                                    </p>
                                                </li>
                                                <li>
                                                    <span>جنسیت</span>
                                                    <p>{{$damdata->gender}}</p>
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
                                                        {{$favoritdata->price}}
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="homBaner homBnerTwo position-relative">
                        <img
                            src="{{asset('img/blue-banner.png')}}"
                            class="linesVector linesVector3"
                            alt="vector"
                        />
                        <a href="{{$indexsetting->baner_two_image_link}}" class="position-relative">
                            <img src="{{$indexsetting->baner_two_image}}" alt="img"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <img
            src="{{asset('img/opening_smile 2.svg')}}"
            class="smileVector"
            alt="vector"
        />
    </section>

    <section class="revOptinSec position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cattleTitl">
                        <span class="icon-Vector-781"></span>
                        <h2>امکانات ریوو</h2>
                    </div>
                    <div class="revOptinBdy position-relative">
                        <ul>
                            <li class="transitionCls position-relative">
                                <div class="position-relative">
                                    <span class="icon-Group-2274"></span>
                                    <strong>ضمانت کیفیت دام</strong>
                                    <p>
                                        دام خریداری شده توسط شما دقیقا مطابق توضیحات فروشگاه خواهد
                                        بود
                                    </p>
                                </div>
                                <img
                                    src="{{asset('img/vector01.png')}}"
                                    class="revVecBtm"
                                    alt="vector"
                                />
                            </li>
                            <li class="transitionCls position-relative">
                                <div class="position-relative">
                                    <span class="icon-Group-2207"></span>
                                    <strong>ضمانت خرید و فروش امن</strong>
                                    <p>
                                        خرید و فروش به صورت کاملا امن و به صورت آنلاین انجام خواهد
                                        شد
                                    </p>
                                </div>
                                <img
                                    src="{{asset('img/vector02.png')}}"
                                    class="revVecTop"
                                    alt="vector"
                                />
                            </li>
                            <li class="transitionCls position-relative">
                                <div class="position-relative">
                                    <span class="icon-Group-2105"></span>
                                    <strong>ضمانت بازگشت پول</strong>
                                    <p>
                                        مبلغ پرداختی خرید یا فروش در صورت عدم رضایت برگرداننده
                                        خواهد شد
                                    </p>
                                </div>
                                <img
                                    src="{{asset('img/vector01.png')}}"
                                    class="revVecBtm"
                                    alt="vector"
                                />
                            </li>
                            <li class="transitionCls position-relative">
                                <div class="position-relative">
                                    <span class="icon-Group-2353"></span>
                                    <strong>پنل دامداری</strong>
                                    <p>
                                        مدیریت آسان و بدون دردسر دام های خریداری و یا فروخته شده
                                    </p>
                                </div>
                                <img
                                    src="{{asset('img/vector02.png')}}"
                                    class="revVecTop"
                                    alt="vector"
                                />
                            </li>
                            <li class="transitionCls position-relative">
                                <div class="position-relative">
                                    <span class="icon-Group-2270"></span>
                                    <strong>پشتیبانی 24 ساعته</strong>
                                    <p>
                                        مدیریت آسان و بدون دردسر دام های خریداری و یا فروخته شده
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="topRanchrSec position-relative">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12">
                    <div class="cattleTitl">
                        <span class="icon-Vector-781"></span>
                        <h2>دامداران برتر</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="topRanchrLst">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($user as $useritem)
                        <div class="swiper-slide">
                            <a href="/sellers/{{$useritem->id}}" class="position-relative transitionCls">
                                <img src="{{$useritem->image}}" alt="{{$useritem->fullname}}"/>
                                <strong class="transitionCls">{{$useritem->username}}</strong>
                                <p>{{$useritem->dam_count}} محصول</p>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="topRanchrBtn">
                    <button class="transitionCls ranchrSldrRght"></button>
                    <button class="transitionCls ranchrSldrLft"></button>
                </div>
            </div>
        </div>
        <div class="topRanchrBg"></div>
    </section>

    <section class="reedMoreSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cattleTitl">
                        <span class="icon-Vector-781"></span>
                        <h2>بیشتر بدانید</h2>
                    </div>
                    <div class="reedMoreBdy">
                        <div class="reedMoreInfo">
                            <div class="reedMoreTxt">
                                <h2>
                                    {{$indexsetting->more_information_title}}
                                </h2>
                                <p>
                                    {{$indexsetting->more_information_text}}
                                </p>
                            </div>
                            <ul>
                                <li>
                                    <strong>{{\App\Models\User::count()}}</strong>
                                    <span>دام دار فعال</span>
                                </li>
                                <li>
                                    <strong>{{\App\Models\Payment::count()}}</strong>
                                    <span>تراکنش موفق</span>
                                </li>
                            </ul>
                            <div class="reedMoreLnk">
                                <a href="{{route('login')}}" class="transitionCls">
                                    <p>همین حالا شروع کنید</p>
                                </a>
                                <a href="{{route('home.about')}}" class="transitionCls">
                                    <span class="icon-Vector-781"></span>
                                    <p>درباره ما</p>
                                    <i class="icon-Group-2210"></i>
                                </a>
                            </div>
                        </div>
                        <div class="reedMoreImg">
                            <img src="{{asset('img/img05.png')}}" alt="img"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="homBlgSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="homBlgHed">
                        <div class="cattleTitl">
                            <span class="icon-Vector-781"></span>
                            <h2>وبلاگ و آموزش</h2>
                        </div>
                        <a href="/blog" class="transitionCls">مشاهده همه مطالب</a>
                    </div>
                    <div class="homBlgBdy">
                        @foreach($article as $rightblog)
                            @if($loop->iteration==1)
                                <a href="{{route('home.blog_post',$rightblog->slug)}}" class="homBlgRght">
                                    <img
                                        src="{{$rightblog->image}}"
                                        class="transitionCls"
                                        alt="img"
                                    />
                                    <div class="homBlgRgTxt">
                                        <h2 class="transitionCls">{{$rightblog->title}}</h2>
                                        <p>
                                            {!!  $rightblog->body !!}
                                        </p>
                                    </div>
                                    <ul>
                                        <li>
                                            <span class="icon-Group-2352"></span>
                                            <strong>{{$rightblog->view_count}}</strong>
                                            <p>بازدید</p>
                                        </li>
                                        <li>
                                            <span class="icon-Group-2353"></span>
                                            <strong>{{$rightblog->rating}}</strong>
                                            <p>امتیاز</p>
                                        </li>
                                        <li>
                                            <span class="icon-Group-2300"></span>
                                            <strong>{{$rightblog->comment_count}}</strong>
                                            <p>دیدگاه</p>
                                        </li>
                                        <li>
                                            <span class="icon-Group-2202"></span>
                                            <p>{{$rightblog->type}}</p>
                                        </li>
                                    </ul>
                                </a>
                            @endif
                        @endforeach
                        <div class="homBlgLeft">
                            @foreach($article as $rightblog)
                                @if($loop->iteration!=1)
                                    <a href="{{route('home.blog_post',$rightblog->slug)}}" class="homBlgPost">
                                        <div class="homBlgPstTop">
                                            <img
                                                src="{{$rightblog->image}}"
                                                class="transitionCls"
                                                alt="img"
                                            />
                                            <div class="homBlgPstTxt homBlgRgTxt">
                                                <h2 class="transitionCls">
                                                    {{$rightblog->title}}
                                                </h2>
                                                <p>
                                                    {{substr($rightblog->body,0,200)}}
                                                </p>
                                            </div>
                                        </div>
                                        <ul>
                                            <li>
                                                <span class="icon-Group-2352"></span>
                                                <strong>{{$rightblog->view_count}}</strong>
                                                <p>بازدید</p>
                                            </li>
                                            <li>
                                                <span class="icon-Group-2353"></span>
                                                <strong>{{$rightblog->rating}}</strong>
                                                <p>امتیاز</p>
                                            </li>
                                            <li>
                                                <span class="icon-Group-2300"></span>
                                                <strong>{{$rightblog->comment_count}}</strong>
                                                <p>دیدگاه</p>
                                            </li>
                                            <li>
                                                <span class="icon-Group-2202"></span>
                                                <p>{{$rightblog->type}}</p>
                                            </li>
                                        </ul>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="questionsSec position-relative">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12">
                    <div class="quSecBox">
                        <div class="cattleTitl">
                            <span class="icon-Vector-781"></span>
                            <h2 id="questions">سوالات متداول</h2>
                        </div>
                        <div class="accordion accordion-flush" id="qAccordion">
                            @php($count = 1)
                            @php($idText="")
                            @foreach($faq as $faqitem)
                                @if($count==1)
                                    @php($idText="flush-collapseOne")
                                @elseif($count==2)
                                    @php($idText="flush-collapseTwo")
                                @elseif($count==3)
                                    @php($idText="flush-collapseThree")
                                @elseif($count==4)
                                    @php($idText="flush-collapseFour")
                                @elseif($count==5)
                                    @php($idText="flush-collapseFive")
                                @elseif($count==6)
                                    @php($idText="flush-collapseSix")
                                @elseif($count==7)
                                    @php($idText="flush-collapseSeven")
                                @elseif($count==8)
                                    @php($idText="flush-collapseEight")
                                @elseif($count==9)
                                    @php($idText="flush-collapseNine")
                                @elseif($count==10)
                                    @php($idText="flush-collapseTen")
                                @endif
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#{{$idText}}"
                                            aria-expanded="false"
                                            aria-controls="{{$idText}}"
                                        >
                                            {{$faqitem->title}}
                                        </button>
                                    </h2>
                                    <div
                                        id="{{$idText}}"
                                        class="accordion-collapse collapse"
                                        data-bs-parent="#qAccordion"
                                    >
                                        <div class="accordion-body">
                                            {{$faqitem->body}}
                                        </div>
                                    </div>
                                </div>
                                @php($count++)
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="questnSecBg"></div>
    </section>
@endsection
