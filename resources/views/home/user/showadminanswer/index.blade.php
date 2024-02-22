@extends('home.master')
@section('content')
    @php($ticketgroupe=json_decode($ticketGroupeData))
    @php($ticketdata=json_decode($ticketData))
    <section class="dashbrdSec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dashbrdBox position-relative">
                        @include('home.user.part.sidebar')
                        <div class="dashLeft">
                            <div class="supportReq">
                                <div class="suprtReqHed">
                                    <div class="sprtReqRght">
                                        <span class="icon-Vector-148"></span>
                                        <div class="sprtReqName">
                                            <strong>{{$ticketgroupe->title}}</strong>
                                            <div>
                                                <p>
                                                    {{$ticketgroupe->created_at}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="statusDiv">
                                        @if($ticketgroupe->status==1)
                                            <i class="statusTag green">پاسخ داده شده</i>
                                        @else
                                            <i class="statusTag orange">در انتظار</i>
                                        @endif
                                        <a
                                            href="{{route('home.user.support')}}"
                                            class="showLink transitionCls"
                                        >
                                            بازگشت
                                        </a>
                                    </div>
                                </div>
                                @foreach($ticketdata as $ticket)
                                    @if($ticket->user_id!=1)
                                        <div class="suprtReqBdy">
                                            <div class="suprtReqUsr">
                                                <img src="{{$ticket->image}}" alt="img"/>
                                                <i>{{$ticket->created_time}}</i>
                                                <i>{{$ticket->created_at}}</i>
                                            </div>
                                            <div class="suprtReqTxt">
                                                <p>
                                                    {{$ticket->body}}
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="sprtReqAnswr position-relative">
                                            <span class="sprtAnswrTag">پاسخ پشتیبانی</span>
                                            <div class="sprtAnswrUsr">
                                                <img src="{{$ticket->image}}" alt="img"/>
                                                <i>{{$ticket->created_time}}</i>
                                                <i>{{$ticket->created_at}}</i>
                                                <span>پاسخ</span>
                                            </div>
                                            <div class="sprtAnswrTxt">
                                                <p>
                                                    {{$ticket->body}}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Ticket Modal -->
    <div
        class="modal fade addTicketMdl"
        id="addTicketMdl"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="ticktMdlRght">
                    <h1>ثبت درخواست پشتیبانی</h1>
                    <form>
                        <select class="form-select mb-3" aria-label="select">
                            <option selected>موضوع تیکت</option>
                            <option value="1">یک</option>
                            <option value="2">دو</option>
                            <option value="3">صه</option>
                        </select>
                        <div class="typeCmntBx">
                            <div class="typeCmntLbl">
                                <span class="icon-Vector-326"></span>
                                <label for="text01">آدرس خود را وارد کنید</label>
                            </div>
                            <textarea
                                class="form-control"
                                id="text01"
                                rows="2"
                                placeholder="ادرس شما"
                            ></textarea>
                        </div>
                    </form>
                    <button
                        class="transitionCls"
                        data-bs-target="#addTicketMdl2"
                        data-bs-toggle="modal"
                    >
                        ذخیره و ثبت اطلاعات
                    </button>
                </div>
                <div class="ticktMdlLft">
                    <strong> نکات مهم قبل از ثبت درخواست پشتیبانی</strong>
                    <ul>
                        <li class="position-relative">عنوان یک</li>
                        <li class="position-relative">نکته شماره دو</li>
                        <li class="position-relative">موضوع شماره 3</li>
                        <li class="position-relative">توضیحات</li>
                        <li class="position-relative">تست 1</li>
                        <li class="position-relative">تست 3</li>
                        <li class="position-relative">تست 4</li>
                        <li class="position-relative">تست 5</li>
                        <li class="position-relative">تست7</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Ticket Modal -->
    <div
        class="modal fade addTicketMdl"
        id="addTicketMdl2"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="ticktMdlRght">
                    <h1>ثبت درخواست پشتیبانی</h1>
                    <div class="tiktMdlSuces">
                        <div>
                            <span class="icon-Vector-148"></span>
                        </div>
                        <strong>تیکت شما با موفقیت ثبت شد</strong>
                        <p>تیم پشتیبانی ریوو در کمتر از 24 ساعت پاسخگوی شما خواهند بود</p>
                    </div>
                </div>
                <div class="ticktMdlLft">
                    <strong> نکات مهم قبل از ثبت درخواست پشتیبانی</strong>
                    <ul>
                        <li class="position-relative">عنوان یک</li>
                        <li class="position-relative">نکته شماره دو</li>
                        <li class="position-relative">موضوع شماره 3</li>
                        <li class="position-relative">توضیحات</li>
                        <li class="position-relative">تست 1</li>
                        <li class="position-relative">تست 3</li>
                        <li class="position-relative">تست 4</li>
                        <li class="position-relative">تست 5</li>
                        <li class="position-relative">تست7</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
