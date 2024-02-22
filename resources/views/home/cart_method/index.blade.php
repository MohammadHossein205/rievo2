@extends('home.master')
@section('content')
    <cart-method :user_id="{{auth()->user()->id}}"
                 :ispay="{{ json_encode(\Illuminate\Support\Facades\Session::get('payment_result'))}}"></cart-method>
@endsection
