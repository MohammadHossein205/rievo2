@extends('home.master')
@section('content')
    @php($factor=json_encode($factors))
    <section class="dashbrdSec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dashbrdBox position-relative">
                        @include('home.user.part.sidebar')
                        <husbandry :factors="{{$factor}}"
                                   :payments="{{json_encode($payments)}}"
                                   :today="{{json_encode(verta(\Carbon\Carbon::now())->format('%d - %m - %Y'))}}"
                                   :selldamcout="{{json_encode($sell_dam_count)}}"
                                   :selldammoney="{{json_encode(number_format($sum_sell))}}"
                                   :buydamcout="{{json_encode($buy_dam_count)}}"
                                   :buydammoney="{{json_encode(number_format($sum_dam))}}"
                                   :userdamcout="{{json_encode($user_dam_count)}}"
                                   :userdammoney="{{json_encode(number_format($sum_buy))}}"
                                   :user="{{auth()->user()}}"
                                   :tax="{{json_encode(\App\Models\Tax::first())}}"
                        ></husbandry>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Inventory Increase Modal -->

@endsection
