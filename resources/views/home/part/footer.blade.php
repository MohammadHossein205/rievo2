<footer>
    @php($contactus=\App\Models\Contactus::latest()->first())
    <div class="foterTop">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="fotrTopBx">
                        <form class="ftrRegBox" action="{{route('join_news')}}" method="post">
                            @csrf
                            <div class="frmInputBx">
                                <span class="icon-Group-2292"></span>
                                <div class="position-relative">
                                    <label for="enterEmail" class="transitionCls"
                                    >ایمیل خود را وارد کنید</label
                                    >
                                    <input
                                        type="email"
                                        id="enterEmail"
                                        name="email"
                                        class="transitionCls"
                                        required
                                    />
                                </div>
                            </div>
                            <button class="transitionCls">عضویت در خبرنامه</button>
                            @if(Session::has('message'))
                                <div class="success">
                                    {!! \Session::get('message') !!}
                                </div>
                            @endif
                        </form>
                        <div class="ftrSupport">
                            <div>
                                <p>پشتیبانی 24 ساعته ریوو</p>
                                <h1>
                                    {{\App\Models\Indexpagesetting::latest()->first()->phone_text}}
                                </h1>
                            </div>
                            <i class="icon-Vector-682"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="foterBox">
                    <div class="footerCol">
                        <strong>دسترسی سریع </strong>
                        <ul class="qAccessMnu">
                            <li>
                                @if(auth()->user())
                                    <a href="{{route('home.user.wallet')}}">
                                        <div class="transitionCls">
                                            <i class="icon-Group-2343"></i>
                                            <span class="icon-Group-2229"></span>
                                        </div>
                                        <p class="transitionCls">کیف پول</p>
                                    </a>
                                @else
                                    <a href="{{route('home.wallet')}}">
                                        <div class="transitionCls">
                                            <i class="icon-Group-2343"></i>
                                            <span class="icon-Group-2229"></span>
                                        </div>
                                        <p class="transitionCls">کیف پول</p>
                                    </a>
                                @endif
                            </li>
                            <li>
                                @if(auth()->user())
                                    <a href="{{route('home.user.husbandry')}}">
                                        <div class="transitionCls">
                                            <i class="icon-Group-2141"></i>
                                            <span class="icon-Group-2229"></span>
                                        </div>
                                        <p class="transitionCls">دامداری</p>
                                    </a>
                                @else
                                    <a href="{{route('home.husbandry')}}">
                                        <div class="transitionCls">
                                            <i class="icon-Group-2141"></i>
                                            <span class="icon-Group-2229"></span>
                                        </div>
                                        <p class="transitionCls">دامداری</p>
                                    </a>
                                @endif
                            </li>
                            <li>
                                <a href="{{route('home.about')}}">
                                    <div class="transitionCls">
                                        <i class="icon-Vector-333"></i>
                                        <span class="icon-Group-2229"></span>
                                    </div>
                                    <p class="transitionCls">درباره ما</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('home.blog')}}">
                                    <div class="transitionCls">
                                        <i class="icon-Vector-285"></i>
                                        <span class="icon-Group-2229"></span>
                                    </div>
                                    <p class="transitionCls">وبلاگ</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('home.shop')}}">
                                    <div class="transitionCls">
                                        <i class="icon-Vector-3811"></i>
                                        <span class="icon-Group-2229"></span>
                                    </div>
                                    <p class="transitionCls">فروشگاه</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('home.contact_us')}}">
                                    <div class="transitionCls">
                                        <i class="icon-Vector-755"></i>
                                        <span class="icon-Group-2229"></span>
                                    </div>
                                    <p class="transitionCls">تماس با ما</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="footerMnu">
                            <li>
                                <a href="#" class="transitionCls">همکاری با ما</a>
                            </li>
                            <li>
                                <a href="#question" class="transitionCls">سوالات متداول</a>
                            </li>
                            <li>
                                <a href="#" class="transitionCls">کسب درآمد</a>
                            </li>
                        </ul>
                    </div>
                    <div class="footerCol ftrCentrCol">
                        <strong>درباره ما</strong>
                        <a href="/" class="footerLogo transitionCls">
                            <img src="{{asset('img/logo/footer_logo.svg')}}" alt="logo" width="20" height="20"
                                 id="logo_footer"/>
                        </a>
                        <p>
                            {{\App\Models\Aboutus::latest()->first()->about_text}}
                        </p>
                        <ul>
                            <li>
                                <a href="#" class="transitionCls">
                                    <img src="{{asset('img/namad02.png')}}" alt="namad"/>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="transitionCls">
                                    <img src="{{asset('img/namad01.png')}}" alt="namad"/>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="transitionCls">
                                    <img src="{{asset('img/namad03.png')}}" alt="namad"/>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="footerCol ftrLeftCol">
                        <strong>ارتباط با ما</strong>
                        <i>در شبکه های اجتماعی</i>
                        <ul>
                            <li>
                                <a href="{{$contactus->telegram}}" class="transitionCls">
                                    <i class="icon-Vector-477"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{$contactus->whatsapp}}" class="transitionCls">
                                    <span class="iconx-whatsapp"></span>
                                </a>
                            </li>
                            <li>
                                <a href="{{$contactus->eitaa}}" class="transitionCls">
                                    <span class="iconx-eitaa"></span>
                                </a>
                            </li>
                            <li>
                                <a href="{{$contactus->instagram}}" class="transitionCls">
                                    <i class="icon-Vector-196"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{$contactus->rubika}}" class="transitionCls">
                                    <i class="iconx-rubika"></i>
                                </a>
                            </li>
                        </ul>
                        <i>راه های ارتباطی</i>
                        <div>
                            <p>
                                {{\App\Models\Indexpagesetting::latest()->first()->phone_text}}
                            </p>
                            <p>
                                {{\App\Models\Contactus::latest()->first()->email}}
                            </p>
                        </div>
                        <p>
                            {{\App\Models\Contactus::latest()->first()->face_to_face}}
                        </p>
                    </div>
                </div>
                <div class="footerBtm">
                    <div class="rievoApp">
                        <img src="{{asset('img/mobile.png')}}" alt="img"/>
                        <div>
                            <h1>ریوو همیشه در جیب شما</h1>
                            <p>
                                با دانلود نرم افزار موبایل ریوو، همیشه و در همه جا دامداری
                                مجازی خود را مدیریت کنید
                            </p>
                        </div>
                    </div>
                    <ul>
                        <li>
                            <a href="#" class="transitionCls">
                                <img src="{{asset('img/app01.png')}}" alt="img"/>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="transitionCls">
                                <img src="{{asset('img/app02.png')}}" alt="img"/>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="transitionCls">
                                <img src="{{asset('img/app03.png')}}" alt="img"/>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="transitionCls">
                                <img src="{{asset('img/app04.png')}}" alt="img"/>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="copyRight">
                    <p>کلیه حقوق و مزایای این سایت برای ریوو محفوظ است</p>
                    <i> All rights reserved</i>
                </div>
            </div>
        </div>
    </div>
</footer>
