<?php

namespace App\Http\Controllers\home\singleDam;

use App\HelperTrait\SeoPage;
use App\HelperTrait\ViewPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DamIndexResource;
use App\Http\Resources\admin\DamvizheResource;
use App\Http\Resources\home\SingleCommentResource;
use App\Models\Comment;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Payment;
use App\Models\Questionanswersetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductInnerController extends Controller
{
    use SeoPage;

    public function singleDam(Dam $dam)
    {
        $this->SeoPage($dam->slug
            , $dam->description
            , 'https://rievo.ir/single/dam/' . $dam->slug
            , $dam->description
            , $dam->slug
            , 'https://rievo.ir/single/dam/' . $dam->slug
            , 'single/dam'
            , 'دامداری ریوو'
            , $dam->slug
            , '@rievo'
            , $dam->slug
            , $dam->description
            , asset('img/logo/header_logo.svg'));
        $damData = json_encode(DamIndexResource::make($dam));
        $sameDam = json_encode(DamIndexResource::collection(Dam::where('group_id', $dam->group_id)->where('id', '!=', $dam->id)->where('status', 1)->get()));

        $questionAnswerSettingData = Questionanswersetting::latest()->get();
        $allCommentCount = DB::table('comments')
            ->where('commentable_id', $dam->id)
            ->selectRaw('count(rate) as rate_count')
            ->groupBy('rate')->get();
        return view('home.singleDam.index', compact('damData', 'sameDam', 'allCommentCount', 'questionAnswerSettingData'));
    }

    public function singleDamVizhe(string $slug)
    {
        $damvizhe = Damvizhe::where('slug', $slug)->first();
        $this->SeoPage($damvizhe->slug
            , $damvizhe->description
            , 'https://rievo.ir/single/damvizhe/' . $damvizhe->slug
            , $damvizhe->description
            , $damvizhe->slug
            , 'https://rievo.ir/single/damvizhe/' . $damvizhe->slug
            , 'single/dam'
            , 'دامداری ریوو'
            , $damvizhe->slug
            , '@rievo'
            , $damvizhe->slug
            , $damvizhe->description
            , asset('img/logo/header_logo.svg'));
        $sameDam = json_encode(DamvizheResource::collection(Damvizhe::where('group_id', $damvizhe->group_id)->where('id', '!=', $damvizhe->id)->where('status', 1)->get()));
        $user = User::where('id', $damvizhe->user_id)->first();
        $userDamCount = count(Payment::where('user_id', $user->id)->get());
        $damData = json_encode(DamvizheResource::make($damvizhe));
        $questionAnswerSettingData = Questionanswersetting::latest()->get();
        $allCommentCount = DB::table('comments')
            ->selectRaw('count(rate) as rate_count')
            ->groupBy('rate')->get();
        return view('home.singleDam.indexVizhe', compact('damData', 'userDamCount', 'user', 'sameDam', 'allCommentCount', 'questionAnswerSettingData'));
    }
}
