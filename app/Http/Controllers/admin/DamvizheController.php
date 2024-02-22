<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DamVizheEditResource;
use App\Http\Resources\admin\DamvizheResource;
use App\Http\Resources\admin\GroupCompanyResource;
use App\Http\Resources\admin\GroupResource;
use App\Models\Damvizhe;
use App\Models\Group;
use App\Models\GroupCompany;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DamvizheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index damvizhes')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $damData = DamvizheResource::collection(Damvizhe::latest()->paginate(10));
        return Inertia::render('Dam/IndexVizhe', compact('damData'));
    }

    public function GetAllDamVizheData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index dams')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Damvizhe::query();
        if ($request->input('search')) {
            $result = $result->where('name', 'LIKE', "%$request->search%")
                ->orWhere('code', 'LIKE', "%$request->search%")
                ->orWhere('price', 'LIKE', "%$request->search%")
                ->orWhere('color', 'LIKE', "%$request->search%");
        }
        return DamvizheResource::collection($result->latest()->paginate(10))->resource;
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
        return Inertia::render('Dam/CreateVizhe', compact('groupData', 'groupcompanyData', 'damCode'));
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
            'colorenglish' => 'required',
            'ageYear' => 'required',
            'ageMonth' => 'required',
            'gender' => 'required',
            'haveMilk' => 'required',
            'description' => 'required',
            'disount_price' => 'required',
            'disount_time' => 'required',
        ]);
        $date = $request->disount_time;
        $dateExplode = explode('/', $date);
        $jalaliArrayDate = Verta::jalaliToGregorian($dateExplode[0], $dateExplode[1], $dateExplode[2]);
        $jalaliStringDate = $jalaliArrayDate[0] . '-' . $jalaliArrayDate[1] . '-' . $jalaliArrayDate[2];
        $dam = Damvizhe::create([
            'group_id' => $request->group_id,
            'group_company_id' => $request->group_company_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'code' => $request->code,
            'price' => $request->price,
            'weight' => $request->weight,
            'color' => $request->color,
            'colorenglish' => $request->colorenglish,
            'ageYear' => $request->ageYear,
            'ageMonth' => $request->ageMonth,
            'gender' => $request->gender,
            'haveMilk' => $request->haveMilk,
            'milk_amount' => $request->milk_amount,
            'description' => $request->description,
            'disount_price' => $request->disount_price,
            'disount_time' => $jalaliStringDate,
        ]);
        $dam->galleries()->attach($request->imageIds);
        return response()->json(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Damvizhe $damvizhe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Damvizhe $damvizhe)
    {
        if (!auth()->user()->hasPermissionTo('edit dam')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $groupData = GroupResource::collection(Group::latest()->get());
        $groupcompanyData = GroupCompanyResource::collection(GroupCompany::latest()->get());
        $damData = DamVizheEditResource::make($damvizhe);
        return Inertia::render('Dam/EditVizhe', compact('damData', 'groupData', 'groupcompanyData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Damvizhe $damvizhe)
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
            'colorenglish' => 'required',
            'ageYear' => 'required',
            'ageMonth' => 'required',
            'gender' => 'required',
            'haveMilk' => 'required',
            'description' => 'required',
            'disount_price' => 'required',
            'disount_time' => 'required',
        ]);
        $date = $request->disount_time;
        $dateExplode = explode('/', $date);
        $jalaliArrayDate = Verta::jalaliToGregorian($dateExplode[0], $dateExplode[1], $dateExplode[2]);
        $jalaliStringDate = $jalaliArrayDate[0] . '-' . $jalaliArrayDate[1] . '-' . $jalaliArrayDate[2];
        $damvizhe->update([
            'group_id' => $request->group_id,
            'group_company_id' => $request->group_company_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'code' => $request->code,
            'price' => $request->price,
            'weight' => $request->weight,
            'color' => $request->color,
            'colorenglish' => $request->colorenglish,
            'ageYear' => $request->ageYear,
            'ageMonth' => $request->ageMonth,
            'gender' => $request->gender,
            'haveMilk' => $request->haveMilk,
            'milk_amount' => $request->milk_amount,
            'description' => $request->description,
            'disount_price' => $request->disount_price,
            'disount_time' => $jalaliStringDate,
        ]);
        $damvizhe->galleries()->detach();
        $damvizhe->galleries()->attach($request->imageIds);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Damvizhe $damvizhe)
    {
        if (!auth()->user()->hasPermissionTo('delete dam')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $damvizhe->delete();
        $damvizhe->galleries()->detach();
        return response()->json(200);
    }

    private function CreateDamUniqCode(string $lenght)
    {
        $AllDamCode = Damvizhe::latest()->get(['code']);
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
