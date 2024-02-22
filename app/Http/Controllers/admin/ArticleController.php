<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index articles')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $articleData = ArticleResource::collection(Article::latest()->paginate(8));
        return Inertia::render('Article/Index', compact('articleData'));
    }

    public function GetAllArticleData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index articles')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Article::query();
        if ($request->input('search')) {
            $result = $result->where('title', 'LIKE', "%$request->search%")
                ->orWhere('body', 'LIKE', "%$request->search%")
                ->orWhere('time', 'LIKE', "%$request->search%")
                ->orWhere('type', 'LIKE', "%$request->search%");
        }
        return ArticleResource::collection($result->latest()->paginate(10))->resource;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create article')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('Article/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create article')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validate = $request->validate([
            'title' => 'required|max:255',
            'image' => 'required',
            'body' => 'required',
            'time' => 'required',
            'type' => 'required',
        ]);
        $articledata = Article::create([
            'title' => $request->title,
            'image' => $request->image,
            'body' => $request->body,
            'time' => $request->time,
            'type' => $request->type,
        ]);
        if ($articledata) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        if (!auth()->user()->hasPermissionTo('edit article')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('Article/Edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        if (!auth()->user()->hasPermissionTo('update article')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validate = $request->validate([
            'title' => 'required|max:255',
            'image' => 'required',
            'body' => 'required',
            'time' => 'required',
            'type' => 'required',
        ]);
        $articledata = $article->update([
            'title' => $request->title,
            'image' => $request->image,
            'body' => $request->body,
            'time' => $request->time,
            'type' => $request->type,
        ]);
        if ($articledata) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if (!auth()->user()->hasPermissionTo('delete article')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        if ($article->delete()) {
            response()->json(200);
        } else {
            response()->json(100);
        }
    }
}
