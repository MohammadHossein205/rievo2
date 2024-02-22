<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DamEditResource;
use App\Http\Resources\admin\DamIndexResource;
use App\Http\Resources\admin\GroupCompanyResource;
use App\Http\Resources\admin\GroupResource;
use App\Models\Dam;
use App\Models\Group;
use App\Models\GroupCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index dams')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $damData = DamIndexResource::collection(Dam::latest()->paginate(10));
        return Inertia::render('Dam/Index', compact('damData'));
    }

    public function GetAllDamData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index dams')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Dam::query();
        if ($request->input('search')) {
            $result = $result->where('name', 'LIKE', "%$request->search%")
                ->orWhere('code', 'LIKE', "%$request->search%")
                ->orWhere('price', 'LIKE', "%$request->search%")
                ->orWhere('color', 'LIKE', "%$request->search%");
        }
        return DamIndexResource::collection($result->latest()->paginate(10))->resource;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create dam')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $groupData = GroupResource::collection(Group::latest()->get());
        $groupcompanyData = GroupCompanyResource::collection(GroupCompany::latest()->get());
        $damCode = $this->CreateDamUniqCode(10);
        return Inertia::render('Dam/Create', compact('groupData', 'groupcompanyData', 'damCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create dam')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $request->validate([
            'group_id' => 'required',
            'group_company_id' => 'required',
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'code' => 'required|min:10|max:10',
            'price' => 'required',
            'weight' => 'required',
            'color' => 'required',
            'color_english' => 'required',
            'ageYear' => 'required',
            'ageMonth' => 'required',
            'gender' => 'required',
            'haveMilk' => 'required',
            'description' => 'required',
        ]);
        $dam = Dam::create([
            'group_id' => $request->group_id,
            'group_company_id' => $request->group_company_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'code' => $request->code,
            'price' => $request->price,
            'weight' => $request->weight,
            'color' => $request->color,
            'color_english' => $request->color_english,
            'ageYear' => $request->ageYear,
            'ageMonth' => $request->ageMonth,
            'gender' => $request->gender,
            'haveMilk' => $request->haveMilk,
            'milk_amount' => $request->milk_amount,
            'description' => $request->description,
        ]);
        $dam->galleries()->attach($request->imageIds);
        return response()->json(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dam $dam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dam $dam)
    {
        if (!auth()->user()->hasPermissionTo('edit dam')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $groupData = GroupResource::collection(Group::latest()->get());
        $groupcompanyData = GroupCompanyResource::collection(GroupCompany::latest()->get());
        $damData = DamEditResource::make($dam);
        return Inertia::render('Dam/Edit', compact('damData', 'groupData', 'groupcompanyData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dam $dam)
    {
        if (!auth()->user()->hasPermissionTo('update dam')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $request->validate([
            'group_id' => 'required',
            'group_company_id' => 'required',
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'code' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'color' => 'required',
            'color_english' => 'required',
            'ageYear' => 'required',
            'ageMonth' => 'required',
            'gender' => 'required',
            'haveMilk' => 'required',
            'description' => 'required',
        ]);
        $dam->update([
            'group_id' => $request->group_id,
            'group_company_id' => $request->group_company_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'code' => $request->code,
            'price' => $request->price,
            'weight' => $request->weight,
            'color' => $request->color,
            'color_english' => $request->color_english,
            'ageYear' => $request->ageYear,
            'ageMonth' => $request->ageMonth,
            'gender' => $request->gender,
            'haveMilk' => $request->haveMilk,
            'milk_amount' => $request->milk_amount,
            'description' => $request->description,
        ]);
        $dam->galleries()->detach();
        $dam->galleries()->attach($request->imageIds);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dam $dam)
    {
        if (!auth()->user()->hasPermissionTo('delete dam')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $dam->delete();
        $dam->galleries()->detach();
        return response()->json(200);
    }

    private function CreateDamUniqCode(string $lenght)
    {
        $AllDamCode = Dam::latest()->get(['code']);
        if (count($AllDamCode) != 0) {
            $Result = "";
            $Count = 0;
            while ($Count != 1) {
                $randCode = Str::upper(Str::random($lenght));
                foreach ($AllDamCode as $item) {
                    if ($item != $randCode) {
                        $Count = 1;
                        $Result = $randCode;
                    }
                }
            }
        } else {
            $Result = Str::upper(Str::random($lenght));
        }
        return $Result;
    }
}
