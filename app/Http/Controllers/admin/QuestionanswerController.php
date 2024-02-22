<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\QuestionAnswerResource;
use App\Http\Resources\home\SingleAnswerQuestionResource;
use App\Models\Dam;
use App\Models\Questionanswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class QuestionanswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questionanswerData = QuestionAnswerResource::collection(Questionanswer::latest()->paginate(10));
        return Inertia::render('QuestionAnswer/Index', compact('questionanswerData'));
    }

    public function GetAllQuestionAnswerData(Request $request)
    {
        $result = Questionanswer::query();
        if ($request->input('search')) {
            $result = $result->where('user_id', 'LIKE', "%$request->search%")
                ->orWhere('body', 'LIKE', "%$request->search%")
                ->orWhere('questionanswerable_type', 'LIKE', "%$request->search%")
                ->orWhere('status', 'LIKE', "%$request->search%");
        }
        return QuestionAnswerResource::collection($result->latest()->paginate(10))->resource;
    }

    public function StoreQuestionAnswer(Request $request, Questionanswer $questionanswer)
    {
        $validation = $request->validate([
            'body' => 'required'
        ]);
        $questionanswer->update([
            'status' => 1,
        ]);
        $result = Questionanswer::create([
            'user_id' => Auth::id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
            'questionanswerable_id' => $request->questionanswerable_id,
            'questionanswerable_type' => Dam::class,
            'status' => $request->status,
        ]);
        if ($result) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    public function getQuestionAnswer(Request $request)
    {
        $result = match ($request->questionanswerable_type) {
            'App\Models\Dam' => Dam::where('id', $request->questionanswerable_id)->first(),
        };
        return SingleAnswerQuestionResource::collection($result->questionanswer()->where('status', 1)->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'body' => 'required'
        ]);
        $result = Questionanswer::create([
            'user_id' => $request->user_id,
            'body' => $request->body,
            'parent_id' => $request->parent_id,
            'questionanswerable_id' => $request->questionanswerable_id,
            'questionanswerable_type' => $request->questionanswerable_type,
            'status' => $request->status,
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
    public function show(Questionanswer $questionanswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Questionanswer $questionanswer)
    {
        return Inertia::render('QuestionAnswer/Edit', compact('questionanswer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Questionanswer $questionanswer)
    {
        $validate = $request->validate([
            'body' => 'required'
        ]);
        $result = $questionanswer->update([
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
    public function destroy(Questionanswer $questionanswer)
    {
        if ($questionanswer->delete()) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
