<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\FaqsettingResource;
use App\Models\Faqsetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqsettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index faqsettings')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $faqData = FaqsettingResource::collection(Faqsetting::latest()->paginate(10));
        return Inertia::render('Faq/Index', compact('faqData'));
    }

    public function GetFaqData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index faqsettings')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Faqsetting::query();
        if ($request->input('search')) {
            $result = $result->where('name', 'LIKE', "%$request->search%")
                ->orWhere('code', 'LIKE', "%$request->search%")
                ->orWhere('price', 'LIKE', "%$request->search%")
                ->orWhere('color', 'LIKE', "%$request->search%");
        }
        return FaqsettingResource::collection($result->latest()->paginate(10))->resource;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create faqsetting')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('Faq/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create faqsetting')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validation = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        $faq = Faqsetting::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        return response()->json(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Faqsetting $faqsetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faqsetting $faqsetting)
    {
        if (!auth()->user()->hasPermissionTo('edit faqsetting')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('Faq/Edit', compact('faqsetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faqsetting $faqsetting)
    {
        if (!auth()->user()->hasPermissionTo('update faqsetting')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validation = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        $faqsetting->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faqsetting $faqsetting)
    {
        if (!auth()->user()->hasPermissionTo('delete faqsetting')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $faqsetting->delete();
        return response()->json(200);
    }
}
