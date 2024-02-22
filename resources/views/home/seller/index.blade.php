@extends('home.master')
@section('content')
    <section class="sellrPgSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sellrPgBox">
                        <div class="sellrPgRght">
                            <div class="sellrPgImg">
                                <img src="{{$user[0]->image}}" alt="{{$user[0]->fullname}}"/>
                                <h1>{{$user[0]->fullname}}</h1>
                                <span>{{count($Dam)}} محصول</span>
                                <i> تاریخ عضویت {{($user[0]->created_at)}} </i>
                            </div>
                            <div class="sellrPgInfo">
                                <div class="shopCatTtl">
                                    <span class="icon-Vector-781"></span>
                                    <strong>اطلاعات فروشنده</strong>
                                </div>
                                <p>
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و
                                    با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه
                                    و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی
                                    تکنولوژی مورد نیاز، و کاربردهای
                                </p>
                                <ul>
                                    <li>
                                        <strong> تعداد دام ها</strong>
                                        <span>{{$user_dam_count}}</span>
                                    </li>
                                    <li>
                                        <strong>دام های خریداری شده</strong>
                                        <span>{{$buy_dam_count}}</span>
                                    </li>
                                    <li>
                                        <strong>دام های فروخته شده</strong>
                                        <span>{{$sell_dam_count}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <rate-range-component
                            :allcommentcount="{{json_encode($allCommentCount)}}"></rate-range-component>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <shop singledam="" :damscount="{{count($damscount)}}" :dams="{{json_encode($Dam)}}"
          :groupname="{{json_encode($damGroup)}}"
          :groupcompany="{{json_encode($groupCompany)}}" :user="{{json_encode($user)}}"
          :isfilter="false"
    >
        <btn-like :like="{{json_encode(hasLike($Dam[0]->id,$Dam[0]->model_type))}}"
                  :id="{{json_encode($Dam[0]->id)}}"
                  type="\App\Models\Dam"></btn-like>
    </shop>
@endsection
