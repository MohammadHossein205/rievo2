@extends('home.master')
@section('content')
    @php($article=json_decode($articleData))
    @php($articlesamedata=json_decode($articleSameData))
    <section class="blgPageSec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="blgPageBx">
                        <div class="blgPgRight">
                            <h1>{{$article->title}}</h1>
                            <div class="blgAuthrBx">
                                <span>{{$article->time}} دقیقه</span>
                                <p><strong>نویسنده:</strong>{{\App\Models\User::where('id',1)->first()->fullname}}</p>
                            </div>
                            <ul class="blgPstInfo">
                                <li>
                                    <span class="icon-Group-2352"></span>
                                    <strong>{{$article->view_count}}</strong>
                                    <p>بازدید</p>
                                </li>
                                <li>
                                    <span class="icon-Group-2353"></span>
                                    <strong>{{$article->rating}}</strong>
                                    <p>امتیاز</p>
                                </li>
                                <li>
                                    <span class="icon-Group-2300"></span>
                                    <strong>{{$article->comment_count}}</strong>
                                    <p>دیدگاه</p>
                                </li>
                                <li>
                                    <span class="icon-Group-2202"></span>
                                    <p>{{$article->type}}</p>
                                </li>
                            </ul>
                            <img
                                src="{{$article->image}}"
                                class="blgPstTopImg blgPstImg"
                                alt="img"
                            />
                            <div class="blgPstTxt">
                                <p>
                                    {!! $article->body !!}
                                </p>
                            </div>
                            <div class="blgPstScore">
                                <strong>امتیاز به این مطلب</strong>
                                <blog-rate-component :articleid="{{json_encode($article->id)}}"></blog-rate-component>
                            </div>
                            <div class="blgCommnt">
                                <form-blog-comment :id="{{json_encode($article->id)}}"
                                                   :type="{{json_encode(\App\Models\Article::class)}}"></form-blog-comment>
                                <ul class="blgRsvComnts">
                                    <list-blog-comment :id="{{json_encode($article->id)}}"
                                                       :type="{{json_encode(\App\Models\Article::class)}}"></list-blog-comment>
                                </ul>
                            </div>
                        </div>
                        <div class="blgPgLeft">
                            <div class="blgLstSecTtl mb-3">
                                <span class="icon-Vector-781"></span>
                                <h2>مطالب مرتبط</h2>
                            </div>
                            @foreach($articlesamedata as $samearticle)
                                <a href="{{route('home.blog_post',$samearticle->slug)}}"
                                   class="blgRelPost transitionCls">
                                    <div class="blgRelPstTxt">
                                        <h2>{{$samearticle->title}}</h2>
                                        <p>
                                            {!! substr($samearticle->body,0,200) !!} . . .
                                        </p>
                                    </div>
                                    <ul class="blgPstInfo">
                                        <li>
                                            <span class="icon-Group-2352"></span>
                                            <strong>{{$samearticle->view_count}}</strong>
                                            <p>بازدید</p>
                                        </li>
                                        <li>
                                            <span class="icon-Group-2353"></span>
                                            <strong>{{$samearticle->rating!=null?:0}}</strong>
                                            <p>امتیاز</p>
                                        </li>
                                    </ul>
                                    <div class="blgRelPstLnk">
                                        <strong class="transitionCls">ادامه مطلب</strong>
                                        <span>{{$samearticle->time}} دقیقه خواندن</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
