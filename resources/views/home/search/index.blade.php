@extends('home.master')
@section('content')
    <search-dam :damcount="{{$dam_count}}"></search-dam>
@endsection
