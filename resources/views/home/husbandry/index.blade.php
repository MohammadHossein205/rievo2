@extends('home.master')
@section('content')
    @php($faq=json_decode($faqData))
    @php($aboutRievo=\App\Models\Aboutus::first())
    <section class="husbndryTop position-relative">
        <div class="hsbndryTopBg1"></div>
        <div class="hsbndryTopBg2"></div>
        <div class="hsbndryTopBx position-relative">
            <h1>
                <span> کسب درآمد </span>
                {{$text->title_text}}
            </h1>
            <p>
                {{$text->title_description}}
            </p>
        </div>
    </section>

    <section class="hsbndryAbut">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hsbndryAbtBx">
                        <span class="icon-Group-2353"></span>
                        <strong>درباره <a href="#">ریوو</a> بیشتر بدانید</strong>
                        <p>
                            {{$aboutRievo->about_text}}
                        </p>
                    </div>
                    <div class="hsbndryTrait marginRL">
                        <div class="cattleTitl">
                            <span class="icon-Vector-781"></span>
                            <h2>ویژگی های دامداری مجازی ریوو</h2>
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
                </div>
            </div>
        </div>
    </section>

    <section class="questionsSec position-relative">
        <div class="container position-relative">
            <div class="row">
                <div class="col-12">
                    <div class="quSecBox marginRL">
                        <div class="cattleTitl">
                            <span class="icon-Vector-781"></span>
                            <h2>سوالات متداول</h2>
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

    <section class="activRanch">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="ranch_bg"></div>
                    <div class="actvRanchBx">
                        <h2>همین حالا دامداری مجازی خود را در ریوو فعال کنید</h2>
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
