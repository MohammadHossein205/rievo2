<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\JoinNewsResource;
use App\Models\JoinNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class JoinNewsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index joinnews')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $joinnewsData = JoinNewsResource::collection(JoinNews::latest()->paginate(10));
        return Inertia::render('JoinNews/Index', compact('joinnewsData'));
    }

    public function GetAllJoinNewsData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index joinnews')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = JoinNews::query();
        if ($request->input('search')) {
            $result = $result->where('user_id', 'LIKE', "%$request->search%")
                ->orWhere('email', 'LIKE', "%$request->search%");
        }
        return JoinNewsResource::collection($result->latest()->paginate(10))->resource;
    }

    public function InsertEmail(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email:rfc,dns'
        ]);
        JoinNews::create([
            'user_id' => auth()->user()->id,
            'email' => $request->email,
        ]);
        return Redirect::back()->with('message', "ایمیل شما ثبت شد");
    }
}
