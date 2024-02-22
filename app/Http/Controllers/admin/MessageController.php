<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\MessageResource;
use App\Http\Resources\admin\UserIndexResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index messages')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $messageData = MessageResource::collection(Message::latest()->paginate(10));
        return Inertia::render('Message/Index', compact('messageData'));
    }

    public function GetAllMessageData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index messages')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Message::query();
        if ($request->input('search')) {
            $result = $result->where('body', 'LIKE', "%$request->search%");
        }
        return MessageResource::collection($result->latest()->paginate(10))->resource;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create message')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $userData = UserIndexResource::collection(User::latest()->get());
        return Inertia::render('Message/Create', compact('userData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $arr = $request->user_id;
        if (!auth()->user()->hasPermissionTo('create message')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $request->validate([
            'user_id' => 'required',
            'body' => 'required',
        ]);
        for ($i = 0; $i < count($arr); $i++) {
            $message = Message::create([
                'user_id' => $arr[$i],
                'body' => $request->body,
            ]);
        }
        if ($message) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        if (!auth()->user()->hasPermissionTo('edit message')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $userData = UserIndexResource::collection(User::latest()->get());
        return Inertia::render('Message/Edit', compact('message', 'userData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        if (!auth()->user()->hasPermissionTo('update message')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $request->validate([
            'user_id' => 'required',
            'body' => 'required',
        ]);
        $result = $message->update([
            'user_id' => $request->user_id,
            'body' => $request->body,
        ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        if (!auth()->user()->hasPermissionTo('delete message')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        if ($message->delete()) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
