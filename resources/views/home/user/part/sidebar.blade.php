<div class="dashRight">
    <div class="dashUser">
        <span class="icon-Group-2368 opnUserMnu"></span>
        <div class="dashUsrInfo">
            @if(auth()->user()->image)
                <img src="{{auth()->user()->image}}" alt=""/>
            @else
                <img src="{{asset('img/user.svg')}}" alt=""/>
            @endif
            <div>
                <strong>{{auth()->user()->fullname}}</strong>
                <p>{{auth()->user()->mobile}}</p>
            </div>
        </div>
        <a href="{{route('home.user.notification')}}" class="dashHavNtf position-relative">
            <span class="icon-Vector-710"></span>
        </a>
    </div>
    <div class="dashMenu transitionCls position-relative">
        <ul>
            <li>
                <a href="{{route('home.user.dashboard')}}" class="{{checkURL('/user/dashboard')?'active':''}}">
                    <div>
                        <span class="icon-Group-2151"></span>
                        <p class="transitionCls">حساب کاربری</p>
                    </div>
                    <i class="icon-Group-2210"></i>
                </a>
            </li>
            <li>
                <a href="{{route('home.user.husbandry')}}" class="{{checkURL('/user/husbandry')?'active':''}}">
                    <div>
                        <span class="icon-Vector-517"></span>
                        <p class="transitionCls">دامداری</p>
                    </div>
                    <i class="icon-Group-2210"></i>
                </a>
            </li>
            <li>
                <a href="{{route('home.user.wallet')}}" class="{{checkURL('/user/wallet')?'active':''}}">
                    <div>
                        <span class="icon-Vector-1091"></span>
                        <p class="transitionCls">کیف پول</p>
                    </div>
                    <i class="icon-Group-2210"></i>
                </a>
            </li>
            <li>
                <a href="{{route('home.user.notification')}}" class="{{checkURL('/user/notification')?'active':''}}">
                    <div>
                        <span class="icon-Vector-781"></span>
                        <p class="transitionCls">پیام ها</p>
                    </div>
                    <i class="icon-Group-2210"></i>
                </a>
            </li>
            <li>
                <a href="{{route('home.user.devices')}}" class="{{checkURL('/user/devices')?'active':''}}">
                    <div>
                        <span class="icon-Vector-748"></span>
                        <p class="transitionCls">دستگاه های متصل</p>
                    </div>
                    <i class="icon-Group-2210"></i>
                </a>
            </li>
            <li>
                <a href="{{route('home.user.support')}}" class="{{checkURL('/user/support')?'active':''}}">
                    <div>
                        <span class="icon-Vector-148"></span>
                        <p class="transitionCls">پشتیبانی</p>
                    </div>
                    <i class="icon-Group-2210"></i>
                </a>
            </li>
        </ul>
        <a href="{{route('logout')}}" class="transitionCls logout">
            <span class="icon-Group-2291"></span>
            <p>خروج از حساب</p>
        </a>
    </div>
</div>
