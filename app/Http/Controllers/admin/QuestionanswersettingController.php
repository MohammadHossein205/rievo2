<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\QuestionAnswerResource;
use App\Http\Resources\admin\QuestionAnswerSettingResource;
use App\Models\Questionanswersetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionanswersettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index questionanswersettings')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $questionanswersettingData = QuestionAnswerSettingResource::collection(Questionanswersetting::latest()->paginate(10));
        return Inertia::render('QuestionAnswerSetting/Index', compact('questionanswersettingData'));
    }

    public function GetAllQuestionAnswerSettingData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index questionanswersettings')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Questionanswersetting::query();
        if ($request->input('search')) {
            $result = $result->where('text', 'LIKE', "%$request->search%");
        }
        return QuestionAnswerSettingResource::collection($result->latest()->paginate(10))->resource;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('index questionanswersettings')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('QuestionAnswerSetting/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('store questionanswersetting')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validate = $request->validate([
            'text' => 'required'
        ]);
        $result = Questionanswersetting::create([
            'text' => $request->text,
        ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Questionanswersetting $questionanswersetting)
    {
        if (!auth()->user()->hasPermissionTo('edit questionanswersettings')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('QuestionAnswerSetting/Edit', compact('questionanswersetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Questionanswersetting $questionanswersetting)
    {
        if (!auth()->user()->hasPermissionTo('update questionanswersettings')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validate = $request->validate([
            'text' => 'required'
        ]);
        $result = $questionanswersetting->update([
            'text' => $request->text,
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
    public function destroy(Questionanswersetting $questionanswersetting)
    {
        if (!auth()->user()->hasPermissionTo('delete questionanswersettings')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        if ($questionanswersetting->delete()) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
