@extends('home.master')
@section('content')
    <section class="dashbrdSec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dashbrdBox position-relative">
                        @include('home.user.part.sidebar')
                        <div class="dashLeft">
                            <div class="dashWallet pt-2" id="frm">
                                <h2>کیف پول</h2>
                                <user-wallet :user="{{auth()->user()}}" :id="{{auth()->user()->id}}"
                                             :paymentcondition="{{$payment_condition}}"
                                             :money="{{$wallet}}"
                                             :ispaid="{{json_encode(\Illuminate\Support\Facades\Session::get('payment_result'))}}"
                                ></user-wallet>
                                <div class="tabBox">
                                    <div class="tabBXHeader">
                                        <ul>
                                            <li>
                                                <a href="#" class="tablinks active transitionCls" tabId="tabOne"
                                                   id="defaultOpen"> مدیریت کارت های بانکی </a>
                                            </li>
                                            <li>
                                                <a href="#" class="tablinks transitionCls" tabId="tabTwo"> تاریخچه
                                                    تراکنش ها </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="exprtChkTab">
                                        <div id="tabOne" class="tabcontent">
                                            <ul class="xprtChkBank">
                                                <li>
                                                    <a href="#" data-bs-target="#addBankMdl1" data-bs-toggle="modal">
                                                        <span class="icon-Vector-672"></span>
                                                        <i>اضافه کردن کارت بانکی جدید</i>
                                                    </a>
                                                </li>
                                                <card-component :user="{{auth()->user()}}"></card-component>
                                            </ul>
                                        </div>
                                        <div id="tabTwo" class="tabcontent">
                                            <div class="table-responsive">
                                                <card-activity></card-activity>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Bank Card Modal -->
    <card :user="{{auth()->user()}}"></card>

    <!-- Add Bank Card Modal -->

    <!-- WithdrawMdl Modal -->
    <div class="modal fade increaseMdl withdrawMdl" id="withdrawMdl1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="withdrwReslt">
                    <div><span class="icon-Vector-103"></span></div>
                    <strong>درخواست برداشت از کیف پول با موفقیت ثبت شد</strong>
                    <p>نتیجه درخواست شما در کمترین زمان به اطلاع شما خواهد رسید</p>
                    <button data-bs-dismiss="modal" aria-label="Close">متوجه شدم</button>
                </div>
            </div>
        </div>
    </div>
@endsection
