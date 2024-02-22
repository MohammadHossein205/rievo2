<?php

namespace App\Http\Controllers\home\blog;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    use  SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | مقاله آموزشی'
            , 'مقالات آموزشی و اطلاعاتی راجب دام ها'
            , 'https://rievo.ir/article'
            , 'مقالات آموزشی و اطلاعاتی راجب دام ها'
            , 'ریوو | مقاله آموزشی'
            , 'https://rievo.ir/article'
            , 'article'
            , 'دامداری ریوو'
            , 'ریوو | مقاله آموزشی'
            , '@rievo'
            , 'ریوو | مقاله آموزشی'
            , 'مقالات آموزشی و اطلاعاتی راجب دام ها'
            , asset('img/logo/header_logo.svg'));
        $articelData = ArticleResource::collection(Article::latest()->paginate(8))->resource;
//        $collectData = collect($articelData);
//        $arraydataOne = ($collectData->slice(0, 4));
//        $arraydataTwo = ($collectData->slice(4, 4));
        return view('home.blog.index', compact('articelData'));
    }

    public function store(Request $request)
    {
        $rating = "";
        $article = Article::where('id', $request->article_id)->first();
        if (!Auth::check()) {
            return response()->json(100);
        } else {
            $allrate = $article->getAllRatings($article->id)->first();
            if ($allrate == '') {
                $rating = $article->rating([
                    'rating' => $request->rate,
                ], Auth::user());
            } else {
                $rating = $article->updateRating($allrate->id, [
                    'rating' => $request->rate,
                ]);
            }

        }
        if ($rating) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    public function GetAllBlogsData()
    {
        return ArticleResource::collection(Article::latest()->paginate(8))->resource;
    }
}
