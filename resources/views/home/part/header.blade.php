<header>
    @if(auth()->check())
        @if(auth()->user()->can('admin index'))
            <div class="main-dashboard-access">
                <div class="main-dashboard-access-item container">
                    <a href="{{route('admin.index')}}">
                        <svg class="icon">
                            <use xlink:href="#setting-dashboard"></use>
                        </svg>
                        <strong>داشبورد</strong>
                    </a>
                </div>
            </div>
        @endif
    @endif
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="headerBx">
                    <div class="hdrRight">
                        <a href="/" class="hdrLogo transitionCls">
                            <img src="{{asset('img/logo/header_logo.svg')}}" alt="logo" width="20" height="20"
                                 id="logo"/>
                        </a>
                        <p>
                            امروز
                            {{verta(\Carbon\Carbon::now())->format('%d %B %Y')}}
                        </p>

                        <!-- Hide when width is less than 991 -->
                        <ul>
                            <li>
                                <a href="{{route('home.contact_us')}}" class="transitionCls">همکاری با ما</a>
                            </li>
                            <li>
                                <a href="#questions" class="active transitionCls">سوالات متداول</a>
                            </li>
                            <li>
                                <a href="#" class="transitionCls">کسب درآمد</a>
                            </li>
                        </ul>
                    </div>
                    <div class="hdrLeft">
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
    <div class="headerSec transitionCls">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hdrNavBox">
                        <div class="navRight position-relative">
                            <span class="icon-Group-2372 opnSideMnu"></span>
                            <div class="navMenuBx transitionCls">
                    <span
                        class="icon-Vector-504 closSidMnu transitionCls"
                    ></span>
                                <ul class="navMnuUl">
                                    <li>
                                        @if(auth()->check())
                                            <a href="{{route('home.user.husbandry')}}"
                                               class="{{checkURL('/husbandry')?'active':''}}">
                                                <div class="transitionCls">
                                                    <i class="icon-Group-2141"></i>
                                                    <span class="icon-Group-2229"></span>
                                                </div>
                                                <p class="transitionCls">دامداری</p>
                                            </a>
                                        @else
                                            <a href="{{route('home.husbandry')}}"
                                               class="{{checkURL('/husbandry')?'active':''}}">
                                                <div class="transitionCls">
                                                    <i class="icon-Group-2141"></i>
                                                    <span class="icon-Group-2229"></span>
                                                </div>
                                                <p class="transitionCls">دامداری</p>
                                            </a>
                                        @endif
                                    </li>
                                    <li>
                                        @if(auth()->check())
                                            <a href="{{route('home.user.wallet')}}"
                                               class="{{checkURL('/wallet')?'active':''}}">
                                                <div class="transitionCls">
                                                    <i class="icon-Group-2343"></i>
                                                    <span class="icon-Group-2229"></span>
                                                </div>
                                                <p class="transitionCls">کیف پول</p>
                                            </a>
                                        @else
                                            <a href="{{route('home.wallet')}}"
                                               class="{{checkURL('/wallet')?'active':''}}">
                                                <div class="transitionCls">
                                                    <i class="icon-Group-2343"></i>
                                                    <span class="icon-Group-2229"></span>
                                                </div>
                                                <p class="transitionCls">کیف پول</p>
                                            </a>
                                        @endif
                                    </li>
                                    <li>
                                        <a href="{{route('home.shop')}}" class="{{checkURL('/shop')?'active':''}}">
                                            <div class="transitionCls">
                                                <i class="icon-Vector-3811"></i>
                                                <span class="icon-Group-2229"></span>
                                            </div>
                                            <p class="transitionCls">فروشگاه</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('home.blog')}}" class="{{checkURL('/blog')?'active':''}}">
                                            <div class="transitionCls">
                                                <i class="icon-Vector-285"></i>
                                                <span class="icon-Group-2229"></span>
                                            </div>
                                            <p class="transitionCls">وبلاگ</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('home.about')}}" class="{{checkURL('/about')?'active':''}}">
                                            <div class="transitionCls">
                                                <i class="icon-Vector-333"></i>
                                                <span class="icon-Group-2229"></span>
                                            </div>
                                            <p class="transitionCls">درباره ما</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('home.contact_us')}}"
                                           class="{{checkURL('/contact_us')?'active':''}}">
                                            <div class="transitionCls">
                                                <i class="icon-Vector-755"></i>
                                                <span class="icon-Group-2229"></span>
                                            </div>
                                            <p class="transitionCls">تماس با ما</p>
                                        </a>
                                    </li>
                                </ul>

                                <!-- Show when width is less than 991 -->
                                <ul class="hdrTopMnu">
                                    <li>
                                        <a href="#" class="transitionCls">همکاری با ما</a>
                                    </li>
                                    <li>
                                        <a href="#" class="active transitionCls"
                                        >سوالات متداول</a
                                        >
                                    </li>
                                    <li>
                                        <a href="#" class="transitionCls">کسب درآمد</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="navLeft position-relative">
                            <!-- logout -->
                            <ul>
                                <div class="theme-switch-wrapper">
                                    <label class="theme-switch" for="checkbox">
                                        <input type="checkbox" id="checkbox"/>
                                        <div class="slider-theme round"></div>
                                    </label>
                                </div>
                                <li>
                                    <a href="{{route('home.cart')}}" class="transitionCls position-relative">
                                        <span class="icon-Group-2108"></span>
                                        <i></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('home.search')}}" class="transitionCls position-relative">
                                        <span class="icon-Group-2099"></span>
                                    </a>
                                </li>
                            </ul>
                            @if(auth()->check())
                                <a href="{{route('home.user.dashboard')}}" class="navProflLnk transitionCls">
                                    <div class="navProflDiv">
                                        <p class="position-relative">
                                            <span class="icon-Vector-710"></span>
                                            <small></small>
                                        </p>
                                        <div>
                                            <h1>{{auth()->user()->fullname}}</h1>
                                            {{--                                            <i>{{auth()->user()->mobile}}</i>--}}
                                        </div>
                                    </div>
                                    @if(auth()->user()->image)
                                        <img src="{{auth()->user()->image}}" alt=""/>
                                    @else
                                        <img src="{{asset('img/user.svg')}}" alt=""/>
                                    @endif
                                </a>
                                {{--                                <a href="" class="navUserBx transitionCls">--}}
                                {{--                                    <span class="icon-Group-2151"></span>--}}
                                {{--                                </a>--}}
                            @else
                                <a href="{{route('login')}}" class="navUserBx transitionCls">
                                    <span class="icon-Group-2151"></span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="hdrNavBg"></div>
                </div>
            </div>
        </div>
    </div>
</header>
