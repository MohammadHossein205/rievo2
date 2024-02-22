<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\FakeCommentResource;
use App\Models\Fakecomment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FakecommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index fakecomments')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $fakecommentData = FakeCommentResource::collection(Fakecomment::latest()->paginate(10));
        return Inertia::render('FakeComment/Index', compact('fakecommentData'));
    }

    public function GetFakeCommentData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index fakecomments')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Fakecomment::query();
        if ($request->input('search')) {
            $result = $result->where('namefamily', 'LIKE', "%$request->search%")
                ->orWhere('body', 'LIKE', "%$request->search%")
                ->orWhere('status', 'LIKE', "%$request->search%");
        }
        return FakeCommentResource::collection($result->latest()->paginate(10))->resource;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create fakecomment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('FakeComment/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create fakecomment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validation = $request->validate([
            'namefamily' => 'required|max:255',
            'body' => 'required',
        ]);
        $result = "";
        if ($request->image != null) {
            $result = Fakecomment::create([
                'namefamily' => $request->namefamily,
                'image' => $request->image,
                'body' => $request->body,
                'status' => 1,
            ]);
        } else {
            $result = Fakecomment::create([
                'namefamily' => $request->namefamily,
                'image' => asset('img/user-comment-icon.png'),
                'body' => $request->body,
                'status' => 1,
            ]);
        }

        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Fakecomment $fakecomment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fakecomment $fakecomment)
    {
        if (!auth()->user()->hasPermissionTo('edit fakecomment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('FakeComment/Edit', compact('fakecomment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fakecomment $fakecomment)
    {
        if (!auth()->user()->hasPermissionTo('update fakecomment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validation = $request->validate([
            'namefamily' => 'required|max:255',
            'body' => 'required',
        ]);
        $result = "";
        if ($request->image != null) {
            $result = $fakecomment->update([
                'namefamily' => $request->namefamily,
                'image' => $request->image,
                'body' => $request->body,
                'status' => 1,
            ]);
        } else {
            $result = $fakecomment->update([
                'namefamily' => $request->namefamily,
                'image' => asset('img/user-comment-icon.png'),
                'body' => $request->body,
                'status' => 1,
            ]);
        }

        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fakecomment $fakecomment)
    {
        if (!auth()->user()->hasPermissionTo('delete fakecomment')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        if ($fakecomment->delete()) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
