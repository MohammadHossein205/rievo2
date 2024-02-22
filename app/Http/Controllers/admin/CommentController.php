<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\CommentIndexResource;
use App\Http\Resources\home\SingleCommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Dam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index comments')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $commentData = CommentIndexResource::collection(Comment::latest()->paginate(10));
        return Inertia::render('Comments/Index', compact('commentData'));
    }

    public function GetAllCommentData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index comments')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Comment::query();
        if ($request->input('search')) {
            $result = $result->where('body', 'LIKE', "%$request->search%")
                ->orWhere('user_id', 'LIKE', "%$request->search%")
                ->orWhere('status', 'LIKE', "%$request->search%")
                ->orWhere('is_seen', 'LIKE', "%$request->search%");
        }
        return CommentIndexResource::collection($result->latest()->paginate(10))->resource;
    }

    public function getComments(Request $request)
    {
        $result = match ($request->commentable_type) {
            'App\Models\Dam' => Dam::where('id', $request->commentable_id)->first(),
            'App\Models\Article' => Article::where('id', $request->commentable_id)->first(),
        };
        return SingleCommentResource::collection($result->comments()->where('status', 1)->latest()->get());
    }

    public function getBlogComments(Request $request)
    {
        $result = match ($request->commentable_type) {
            'App\Models\Article' => Article::where('id', $request->commentable_id)->first(),
        };
        return SingleCommentResource::collection($result->comments()->where('status', 1)->latest()->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(1);
        }
        $validate = $request->validate([
            'body' => 'required',
        ]);
        $comment = auth()->user()->comments()->create([
            'user_id' => $request->user_id,
            'body' => $request->body,
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
            'rate' => $request->rate,
            'status' => 0,
            'is_seen' => 0,
        ]);
        if ($comment) {
            return response()->json(200);

        } else {
            return response()->json(100);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        if (!auth()->user()->hasPermissionTo('edit comment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('Comments/Edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        if (!auth()->user()->hasPermissionTo('update comment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $request->validate([
            'body' => 'required'
        ]);
        $comment->update([
            'body' => $request->body
        ]);
        return response()->json(200);
    }

    public function SeenComment(Request $request, string $id)
    {
        if (!auth()->user()->hasPermissionTo('seen comment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $comment = Comment::where('id', $id)->first();
        $comment->update([
            'is_seen' => $request->is_seen,
        ]);
        return response()->json(200);
    }

    public function StatusComment(Request $request, string $id)
    {
        if (!auth()->user()->hasPermissionTo('status comment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $comment = Comment::where('id', $id)->first();
        $comment->update([
            'status' => $request->status,
        ]);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if (!auth()->user()->hasPermissionTo('delete comment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $comment->delete();
        return response()->json(200);
    }
}
