<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupData = GroupResource::collection(Group::latest()->paginate(5));
        return Inertia::render('Group/Index', compact('groupData'));
    }

    public function GetAllGroupData(Request $request)
    {
        $result = Group::query();
        if ($request->input('search')) {
            $result = $result->where('name', 'LIKE', "%$request->search%");
        }
        return GroupResource::collection($result->latest()->paginate(5))->resource;
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
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'required',
        ]);
        Group::create([
            'name' => $request->name,
            'image' => $request->image,
        ]);
        return response()->json(200);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'required',
        ]);
        $group->update([
            'name' => $request->name,
            'image' => $request->image,
        ]);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return response()->json(200);
    }
}
