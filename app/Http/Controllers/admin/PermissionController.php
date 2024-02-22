<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\PermissionResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index permissions')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $permissionData = PermissionResource::collection(Permission::latest()->paginate(10));
        return Inertia::render('Permission/Index', compact('permissionData'));
    }

    public function GetAllPermissionData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index permissions')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Permission::query();
        if ($request->input('search')) {
            $result = $result->where('name', 'LIKE', "%$request->search%")
                ->orWhere('persian_name', 'LIKE', "%$request->search%")
                ->orWhere('guard_name', 'LIKE', "%$request->search%");
        }
        return PermissionResource::collection($result->latest()->paginate(10))->resource;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create permission')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('Permission/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create permission')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validation = $request->validate([
            'name' => 'required',
            'persian_name' => 'required',
        ]);
        Permission::create([
            'name' => $request->name,
            'persian_name' => $request->persian_name,
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
    public function edit(Permission $permission)
    {
        if (!auth()->user()->hasPermissionTo('edit permission')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return Inertia::render('Permission/Edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        if (!auth()->user()->hasPermissionTo('update permission')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validation = $request->validate([
            'name' => 'required',
            'persian_name' => 'required',
        ]);
        $permission->update([
            'name' => $request->name,
            'persian_name' => $request->persian_name,
        ]);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        if (!auth()->user()->hasPermissionTo('delete permission')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $permission->delete();
        return response()->json(200);
    }
}
