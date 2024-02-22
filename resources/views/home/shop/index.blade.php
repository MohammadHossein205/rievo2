@extends('home.master')
@section('content')
    <shop :singledam="{{json_encode($damVizhe)}}" :damscount="{{count($damscount)}}" :dams="{{json_encode($Dam)}}"
          :groupname="{{json_encode($damGroup)}}"
          :groupcompany="{{json_encode($groupCompany)}}"
          :isfilter="true"
    >
        <btn-like :like="{{json_encode(hasLike($Dam[0]->id,$Dam[0]->model_type))}}"
                  :id="{{json_encode($Dam[0]->id)}}"
                  type="\App\Models\Dam"></btn-like>
    </shop>
@endsection
