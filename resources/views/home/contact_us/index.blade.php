@extends('home.master')
@section('content')
    @foreach($contactusData as $contactus)@endforeach
    <section class="contactSec">
        <div class="contactMap">
            {{--            <iframe--}}
            {{--                frameborder="0"--}}
            {{--                scrolling="no"--}}
            {{--                marginheight="0"--}}
            {{--                marginwidth="0"--}}
            {{--                src="https://www.openstreetmap.org/export/embed.html?bbox=-16.875000000000004%2C-11.5230875068685%2C117.77343750000001%2C66.65297740055279&amp;layer=mapnik&amp;marker=36.59788913307022%2C50.44921875"--}}
            {{--            ></iframe>--}}
            <a href="{{$contactus->location_link}}">
                <img src="{{$contactus->location_image}}" alt="">
            </a>
        </div>
        <div class="contactFrm">
            <h1>ارتباط با تیم <span>ریوو</span></h1>
            <ul>
                <li>
                    <div class="cntctWayTtl">
                        <hr/>
                        <div>
                            <strong>ارتباط حضوری</strong>
                            <span class="icon-Group-2294"></span>
                        </div>
                    </div>
                    <div class="cntctWayBdy">
                        <p>
                            {{$contactus->face_to_face}}
                        </p>
                    </div>
                </li>
                <li>
                    <div class="cntctWayTtl">
                        <hr/>
                        <div>
                            <strong>راه های ارتباطی</strong>
                            <span class="icon-Vector-683"></span>
                        </div>
                    </div>
                    <div class="cntctWayBdy">
                        {!! $contactus->link_way !!}
                    </div>
                </li>
                <li>
                    <div class="cntctWayTtl">
                        <hr/>
                        <div>
                            <strong>ارتباط ایمیلی</strong>
                            <span class="icon-Group-2292"></span>
                        </div>
                    </div>
                    <div class="cntctWayBdy">
                        <p>
                            {{$contactus->email}}
                        </p>
                    </div>
                </li>
                <li>
                    <div class="cntctWayTtl">
                        <hr/>
                        <div>
                            <strong>شبکه اجتماعی</strong>
                            <span class="icon-Vector-543"></span>
                        </div>
                    </div>
                    <div class="cntctWayBdy">
                        <div class="cntctSotial">
                            <a href="{{$contactus->telegram}}" class="transitionCls">
                                <i class="icon-Vector-477"></i>
                            </a>
                            <a href="{{$contactus->whatsapp}}" class="transitionCls">
                                <span class="iconx-whatsapp"></span>
                            </a>
                            <a href="{{$contactus->eitaa}}" class="transitionCls">
                                <span class="iconx-eitaa"></span>
                            </a>
                            <a href="{{$contactus->instagram}}" class="transitionCls">
                                <i class="icon-Vector-196"></i>
                            </a>
                            <a href="{{$contactus->eitaa}}" class="transitionCls">
                                <i class="iconx-rubika"></i>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contactBg">
                        <img src="{{asset('img/bg04.png')}}" alt="img"/>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
