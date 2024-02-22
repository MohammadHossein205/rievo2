<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\RoleResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index roles')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $roleData = RoleResource::collection(Role::latest()->paginate(10));
        return Inertia::render('Role/Index', compact('roleData'));
    }

    public function GetAllRoleData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index roles')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Role::query();
        if ($request->input('search')) {
            $result = $result->where('name', 'LIKE', "%$request->search%");
        }
        return RoleResource::collection($result->latest()->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create role')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $permissionData = Permission::get(['id', 'persian_name']);
        return Inertia::render('Role/Create', compact('permissionData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create role')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validation = $request->validate([
            'name' => 'required'
        ]);
        Role::create([
            'name' => $request->name,
        ])->syncPermissions($request->permissionIDs);
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
    public function edit(Role $role)
    {
        if (!auth()->user()->hasPermissionTo('edit role')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $rolePermission = $role->givePermissionTo();
        $permissionData = Permission::get(['id', 'persian_name']);
        return Inertia::render('Role/Edit', compact('role', 'rolePermission', 'permissionData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if (!auth()->user()->hasPermissionTo('update role')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $validation = $request->validate([
            'name' => 'required'
        ]);
        $role->update([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->permissionIDs);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (!auth()->user()->hasPermissionTo('delete role')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $role->delete();
        return response()->json(200);
    }
}
