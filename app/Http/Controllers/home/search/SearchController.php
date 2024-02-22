<?php

namespace App\Http\Controllers\home\search;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DamIndexResource;
use App\Models\Dam;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | جستجو دام'
            , 'جستجو دام به صورت حرفه ایی'
            , 'https://rievo.ir/search'
            , 'جستجو دام به صورت حرفه ایی'
            , 'ریوو | جستجو دام'
            , 'https://rievo.ir/search'
            , 'search'
            , 'دامداری ریوو'
            , 'ریوو | جستجو دام'
            , '@rievo'
            , 'ریوو | جستجو دام'
            , 'جستجو دام به صورت حرفه ایی'
            , asset('img/logo/header_logo.svg'));
        $dam_count = Dam::all()->count();
        return view('home.search.index', compact('dam_count'));
    }

    public function FindDam(Request $request)
    {
        $text = $request->text;
        $dam = Dam::query();
        if ($text) {
            $dam = $dam->where('name', 'LIKE', "%$text%")->where('status', 1);
        }
        return DamIndexResource::collection($dam->latest()->get());
    }
}
