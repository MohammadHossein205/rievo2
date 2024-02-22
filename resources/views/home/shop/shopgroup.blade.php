@extends('home.master')
@section('content')
    <shop singledam="" :damscount="{{$damscount}}" :dams="{{json_encode($Dam)}}"
          :groupname="{{json_encode($damGroup)}}"
          :groupcompany="{{json_encode($groupCompany)}}"
          :isfilter="false"
    >
@endsection
