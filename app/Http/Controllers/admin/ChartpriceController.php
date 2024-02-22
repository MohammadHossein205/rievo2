<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\ChartPriceEditResource;
use App\Http\Resources\admin\ChartPriceResource;
use App\Models\Chartprice;
use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChartpriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index chartprices')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $chartdata = ChartPriceResource::collection(Chartprice::latest()->paginate(10));
        return Inertia::render('Chart/Index', compact('chartdata'));
    }

    public function GetChartPriceData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index chartprices')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Chartprice::query();
        if ($request->input('search')) {
            $result = $result->where('group_id', 'LIKE', "%$request->search%")
                ->orWhere('price', 'LIKE', "%$request->search%");
        }
        return ChartPriceResource::collection($result->latest()->paginate(10))->resource;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create chartprice')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $groupData = Group::latest()->get();
        return Inertia::render('Chart/Create', compact('groupData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create chartprice')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validate = $request->validate([
            'group_id' => 'required',
            'price' => 'required',
        ]);
        $result = Chartprice::create([
            'group_id' => $request->group_id,
            'price' => $request->price,
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
    public function show(Chartprice $chartprice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chartprice $chartprice)
    {
        if (!auth()->user()->hasPermissionTo('edit chartprice')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $groupData = Group::latest()->get();
        $chartpriceData = ChartPriceEditResource::make($chartprice);
        return Inertia::render('Chart/Edit', compact('chartpriceData', 'groupData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chartprice $chartprice)
    {
        if (!auth()->user()->hasPermissionTo('update chartprice')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validate = $request->validate([
            'group_id' => 'required',
            'price' => 'required',
        ]);
        $result = $chartprice->update([
            'group_id' => $request->group_id,
            'price' => $request->price,
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
    public function destroy(Chartprice $chartprice)
    {
        if (!auth()->user()->hasPermissionTo('delete chartprice')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        if ($chartprice->delete()) {
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
