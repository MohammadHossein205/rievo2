@extends('home.master')
@section('content')
    @php($message=json_decode($messageData))
    <section class="dashbrdSec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dashbrdBox position-relative">
                        @include('home.user.part.sidebar')
                        <div class="dashLeft">
                            <div class="dashNotif pt-2">
                                <h2>لیست پیام های شما</h2>
                                <ul>
                                    @foreach($message as $messageitem)
                                        <message :message="{{json_encode($messageitem)}}"></message>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
