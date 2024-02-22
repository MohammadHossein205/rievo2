<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\GroupCompanyResource;
use App\Http\Resources\admin\GroupResource;
use App\Models\Group;
use App\Models\GroupCompany;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupcompanyData = GroupCompanyResource::collection(GroupCompany::latest()->paginate(5));
        $groupData = GroupResource::collection(Group::latest()->get());
        return Inertia::render('GroupCompany/Index', compact('groupcompanyData', 'groupData'));
    }

    public function GetGroupCompanyData(Request $request)
    {
        $result = GroupCompany::query();
        if ($request->input('search')) {
            $result = $result->where('name', 'LIKE', "%$request->search%");
        }
        return GroupCompanyResource::collection($result->latest()->paginate(5))->resource;
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
            'english_name' => 'required|max:255',
        ]);
        GroupCompany::create([
            'group_id' => $request->group_id,
            'name' => $request->name,
            'english_name' => $request->english_name,
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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'english_name' => 'required|max:255',
        ]);
        $groupCompany = GroupCompany::where('id', $id)->first();
        $groupCompany->update([
            'group_id' => $request->group_id,
            'name' => $request->name,
            'english_name' => $request->english_name,
        ]);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroupCompany $groupCompany)
    {
        $groupCompany->delete();
        return response()->json(200);
    }
}
