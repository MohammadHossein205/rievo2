<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="mohmmadTahernezhad">
    <link rel="icon" type="image/svg" href="{{asset('img/logo/favicon.svg')}}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    @vite('resources/css/home.scss')
{{--    <link rel="stylesheet" href="/css/home-c9a7208d.css">--}}
{{--    <link rel="stylesheet" href="/css/home-d78e3e22.css">--}}
</head>
<body>
@include('home.part.svgGlobal')

@include('home.part.header')

<div id="app">
    @yield('content')
</div>

@include('home.part.footer')

@vite('resources/js/home.js')
@yield('script')

@vite('resources/js/home/jquery.min.js')
@vite('resources/js/home/bootstrap.min.js')
@vite('resources/js/home/main.js')
@vite('resources/js/home/swiper-bundle.js')
@vite('resources/js/home/tabs.js')
{{--@vite('resources/js/home/chart.js')--}}
{{--@vite('resources/js/home/persian-date.min.js')--}}
{{--@vite('resources/js/home/persian-datepicker.min.js')--}}


{{--<script type="module" src="/js/home-b18b55df.js"></script>--}}
{{--<script type="module" src="/js/jquery.min.js"></script>--}}
{{--<script type="module" src="/js/bootstrap.min.js"></script>--}}
{{--<script type="module" src="/js/main.js"></script>--}}
{{--<script type="module" src="/js/swiper-bundle.js"></script>--}}
{{--<script type="module" src="/js/tabs.js"></script>--}}
{{--<script type="module" src="/js/chart.js"></script>--}}
{{--<script type="module" src="/js/helpers.segment-5ffe24b8.js"></script>--}}

<script>
    var user ={!! json_encode(auth()->user()) !!}
</script>
</body>
</html>
