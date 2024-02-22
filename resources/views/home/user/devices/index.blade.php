@extends('home.master')
@section('content')
    <section class="dashbrdSec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dashbrdBox position-relative">
                        @include('home.user.part.sidebar')
                        <div class="dashLeft">
                            <div class="dashMyDevic pt-2">
                                <h2>لیست دستگاه های متصل</h2>
                                <div class="myDeviceBx">
                                    <ul>
                                        <li>
                                            <i>دستگاه شما</i>
                                        </li>
                                        @foreach($devices as $device)
                                            @if($device->status==1)
                                                <li>
                                                    <div>
                                                        <strong>{{$device->user_location}}</strong>
                                                        <p>{{$device->ip}}</p>
                                                    </div>
                                                    <span class="icon-Vector-326"></span>
                                                </li>
                                                <li>
                                                    <div>
                                                        <strong>{{$device->browser_name}}</strong>
                                                        <p>{{$device->device}}</p>
                                                    </div>
                                                    <span class="icon-Vector-218"></span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="dashDevicLst">
                                <h2>دستگاه های فعال</h2>
                                <div class="deviceLstBx">
                                    @foreach($devices as $device)
                                        <form
                                            action="{{route('home.user.devices.remove',$device)}}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            @if($device->status==0)
                                                <div class="dashDevicCrd">
                                                    <ul>
                                                        <li>
                                                            <button class="transitionCls">حذف این دستگاه</button>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <strong>{{$device->user_location}}</strong>
                                                                <p>{{$device->ip}}</p>
                                                            </div>
                                                            <span class="icon-Vector-326"></span>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <strong>{{$device->browser_name}}</strong>
                                                                <p>{{$device->device}}</p>
                                                            </div>
                                                            <span class="icon-Vector-218"></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                            @endforeach
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
