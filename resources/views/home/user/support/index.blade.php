@extends('home.master')
@section('content')
    @php($support=json_decode($supportData))
    <section class="dashbrdSec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dashbrdBox position-relative">
                        @include('home.user.part.sidebar')
                        <div class="dashLeft">
                            <div class="dashSuprtHed">
                                <h2>لیست درخواست های پشتیبانی</h2>
                                <a
                                    href=""
                                    class="transitionCls"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addTicketMdl"
                                >ثبت درخواست پشتیبانی</a>
                            </div>
                            <ul class="dashSuprtBdy">
                                @foreach($support as $supportitem)
                                    <li>
                                        <div class="suprtCrdRght">
                                            <span class="icon-Vector-148"></span>
                                            <div class="suprtTgName">
                                                <div>
                                                    <strong>{{$supportitem->title}}</strong>
                                                    @if($supportitem->status==1)
                                                        <i class="green">پاسخ داده شده</i>
                                                    @else
                                                        <i class="orange">در انتظار</i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p>
                                                        {{$supportitem->updated_at}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{route('user.ticket.answer',$supportitem->id)}}"
                                           class="transitionCls">مشاهده جزئیات</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Add Ticket Modal -->
    <user-send-ticket :setting="{{json_encode($settingData)}}"></user-send-ticket>
@endsection
