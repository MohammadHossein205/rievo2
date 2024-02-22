@extends('home.master')
@section('content')
    <cart :tax="{{json_encode(\App\Models\Tax::first())}}" :user="{{auth()->user()}}"></cart>
@endsection
