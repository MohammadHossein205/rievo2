<?php

namespace App\Http\Controllers\home\blog_post;

use App\HelperTrait\SeoPage;
use App\HelperTrait\ViewPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\ArticleResource;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    use ViewPage, SeoPage;

    public function index(Article $article)
    {
        $this->SeoPage($article->slug
            , $article->description
            , 'https://rievo.ir/blog_post/' . $article->slug
            , $article->description
            , $article->slug
            , 'https://rievo.ir/blog_post/' . $article->slug
            , 'blog_post'
            , 'دامداری ریوو'
            , $article->slug
            , '@rievo'
            , $article->slug
            , $article->description
            , asset('img/logo/header_logo.svg'));
        $this->AddView($article);
        $articleSameData = json_encode(ArticleResource::collection(Article::where('type', $article->type)->latest()->get()->take(3)));
        $articleData = json_encode(ArticleResource::make($article));
        return view('home.blog_post.index', compact('articleData', 'articleSameData'));
    }
}
