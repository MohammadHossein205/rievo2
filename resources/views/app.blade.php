<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>پنل مدیریت</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script type="text/javascript">
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            jsPermissions: {!! auth()->check()?auth()->user()->jsPermissions():0 !!}
        }
    </script>
    @inertiaHead
</head>
<body class="bg-[#f7f7f7]">
@include('part.svgGlobal')
@inertia

<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script>
    var user = {!! json_encode(auth()->user()) !!};
    var comment_count = {{\App\Models\Comment::where('is_seen',0)->count()}};
    var ticket_count = {{\App\Models\Ticketgroupe::where('status',0)->count()}};
    var bankcard_count = {{\App\Models\Bankcard::where('status',0)->count()}};
    var questionanswer_count = {{\App\Models\Questionanswer::where('status',0)->count()}};
    var factor_count = {{\App\Models\Factor::where('status',0)->count()}};
    var sell_count = {{\App\Models\Sell::where('status',0)->count()}};
    var getmoney_count = {{\App\Models\Getmoney::where('status',0)->count()}};

    var like_count = {{\App\Models\Like::count()}};
    var user_count = {{\App\Models\User::count()}};
    var view_count = {{\App\Models\View::count()}};
</script>
</body>
</html>
