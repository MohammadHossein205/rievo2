@extends('home.master')
@section('content')
    <section class="dashbrdSec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dashbrdBox position-relative">
                        @include('home.user.part.sidebar')
                        <div class="dashLeft">
                            <div class="dashTopRow">
                                <div class="dashWalltBx">
                                    <h2>کیف پول شما</h2>
                                    <p>موجودی</p>
                                    <div>
                                        <strong>
                                            <i>{{number_format($money->money,0,'.',',')}}</i>
                                            <img src="{{asset('img/toman.png')}}" alt="img"/>
                                        </strong>
                                        <a
                                            href="{{route('home.user.wallet')}}"
                                            class="transitionCls"
                                        >افزایش موجودی</a>
                                    </div>
                                </div>
                                {{--                                <div class="dashTopNtf">--}}
                                {{--                                    <div>--}}
                                {{--                                        <span class="icon-Group-2370"></span>--}}
                                {{--                                        <strong>ثبت نهایی سفارش</strong>--}}
                                {{--                                    </div>--}}
                                {{--                                    <p>--}}
                                {{--                                        کمتر از 24 ساعت دیگر سفارش شما به شماره 3940586 ثبت نهایی--}}
                                {{--                                        خواهد شد. در صورت انصراف قبل از این زمان، اقدام به کنسل--}}
                                {{--                                        کردن آن بنمایید--}}
                                {{--                                    </p>--}}
                                {{--                                </div>--}}
                            </div>
                            <!-- Add Ticket Modal -->

                            <div class="viewHsbndry dashLftDiv">
                                <h2>نمای کلی دامداری</h2>
                                <ul>
                                    <li>
                                        <span class="icon-Vector-1171"></span>
                                        <div>
                                            <strong>{{$user_dam_count}}</strong>
                                            <p>دام های فعال</p>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-522"></span>
                                        <div>
                                            <strong>{{$buy_dam_count}}</strong>
                                            <p>خریداری شده</p>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-5211"></span>
                                        <div>
                                            <strong>{{$sell_dam_count}}</strong>
                                            <p>فروخته شده</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="dashUsrAcc dashLftDiv">
                                <div class="dashUsrAcHed">
                                    <h2>حساب کاربری</h2>
                                    <a
                                        href="#"
                                        class="transitionCls"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUsrMdl"
                                    >ویرایش اطلاعات کاربری</a
                                    >
                                </div>
                                <ul>
                                    <li>
                                        <span class="icon-Vector-548"></span>
                                        <div>
                                            <p>نام و نام خانوادگی</p>
                                            <strong>{{auth()->user()->fullname}}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-2321"></span>
                                        <div>
                                            <p>کد ملی</p>
                                            <strong>{{auth()->user()->nationalCode==''?'-':auth()->user()->nationalCode}}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-326"></span>
                                        <div>
                                            <p>آدرس</p>
                                            <strong>{{auth()->user()->address==''?'-':substr(auth()->user()->address,0,10).' ...'}}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-682"></span>
                                        <div>
                                            <p>شماره موبایل</p>
                                            <strong>{{auth()->user()->mobile==''?'-':auth()->user()->mobile}}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-671"></span>
                                        <div>
                                            <p>ایمیل</p>
                                            <strong>{{auth()->user()->email==''?'-':auth()->user()->email}}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Group-2105"></span>
                                        <div>
                                            <p>رمز عبور</p>
                                            <strong>{{auth()->user()->password==''?'-':substr(auth()->user()->password,0,10).' ...'}}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-5411"></span>
                                        <div>
                                            <p>نام کاربری</p>
                                            <strong
                                                class="enText">{{auth()->user()->username==''?'-':auth()->user()->username}}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-682"></span>
                                        <div>
                                            <p>شماره ثابت</p>
                                            <strong>{{auth()->user()->homeNumber==''?'-':auth()->user()->homeNumber}}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-142"></span>
                                        <div>
                                            <p>تاریخ تولد</p>
                                            <strong>{{auth()->user()->birthDate==''?'-':verta(auth()->user()->birthDate)->format('%d %B %Y')}}</strong>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="dashUsrSet dashUsrAcc dashLftDiv">
                                <div class="dashUsrAcHed">
                                    <h2>تنظیمات اطلاع رسانی</h2>
                                    <a
                                        href="#"
                                        class="transitionCls"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editNtfMdl"
                                    >ویرایش اطلاع رسانی</a
                                    >
                                </div>
                                <ul>
                                    <li>
                                        <span class="icon-Vector-548"></span>
                                        <div>
                                            <p>دریافت اطلاع رسانی از طریق ایمیل</p>
                                            @if($setting->email_notification==1)
                                                <i class="green">بله</i>
                                            @else
                                                <i class="red">خیر</i>
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-2321"></span>
                                        <div>
                                            <p>دریافت تایید ثبت سفارش</p>
                                            @if($setting->new_order_accept_sms==1)
                                                <i class="green">بله</i>
                                            @else
                                                <i class="red">خیر</i>
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <span class="icon-Vector-244"></span>
                                        <div>
                                            <p>دریافت تایید لغو سفارش</p>
                                            @if($setting->new_order_cancel_sms==1)
                                                <i class="green">بله</i>
                                            @else
                                                <i class="red">خیر</i>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit User Modal -->
    <edit-user
        :user="{{$user}}" :birthdate="{{json_encode($birthDate)}}"></edit-user>

    <!-- Edit User Modal Step Two-->

    <!-- Edit Notification Setting Modal -->
    <notification-setting :id="{{auth()->user()->id}}"></notification-setting>

    <!-- Add Ticket Modal -->

    <!-- Add Ticket Modal -->
@endsection
