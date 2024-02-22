<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DiscountCodeResource;
use App\Http\Resources\admin\RoleResource;
use App\Http\Resources\admin\UserIndexResource;
use App\Models\Dashboardsetting;
use App\Models\DiscountCode;
use App\Models\User;
use App\Models\Wallet;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
//        Auth::loginUsingId(1);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index users')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $userData = UserIndexResource::collection(User::latest()->where('id', '!=', Auth::id())->paginate(10));
        $discountData = DiscountCodeResource::collection(DiscountCode::latest()->get());
        $userIdData = User::latest()->get('id');
        return Inertia::render('Users/Index', compact('userData', 'discountData', 'userIdData'));
    }


    public function GetAllUsersData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index users')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = User::query();
        if ($request->input('search')) {
            $result = $result->where('username', 'LIKE', "%$request->search%")
                ->orWhere('fullname', 'LIKE', "%$request->search%")
                ->orWhere('nationalCode', 'LIKE', "%$request->search%")
                ->orWhere('mobile', 'LIKE', "%$request->search%")
                ->orWhere('homeNumber', 'LIKE', "%$request->search%")
                ->orWhere('email', 'LIKE', "%$request->search%");
        }
        return UserIndexResource::collection($result->latest()->where('id', '!=', Auth::id())->paginate(10))->resource;
    }

    public function AddDiscountToUsers(Request $request)
    {
        $userIDS = $request->userids;
        $userData = User::all();
        for ($i = 0; $i < count($userIDS); $i++) {
            $selectUser = $userData->where('id', $userIDS[$i])->first();
            $selectUser->update(['discount_id' => $request->discountid]);
            $selectUser->discountcodes()->sync($request->discountid);
        }
        return response()->json(200);
    }

    public function RemoveUsersDiscount(Request $request)
    {
        $userIDS = $request->userids;
        $userData = User::all();
        for ($i = 0; $i < count($userIDS); $i++) {
            $selectUser = $userData->where('id', $userIDS[$i])->first();
            $selectUser->update(['discount_id' => 'null']);
            $selectUser->discountcodes()->detach($request->discountid);
        }
        return response()->json(200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create user')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $roleData = RoleResource::collection(Role::latest()->get());
        return Inertia::render('Users/Create', compact('roleData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create user')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $request->validate([
            'username' => 'required|max:255',
            'fullname' => 'required|max:255',
            'password' => 'required|min:8',
            'image' => 'required',
            'nationalCode' => 'required|digits:10|min:10|max:10',
            'mobile' => 'required|digits:11|min:11|max:11',
            'homeNumber' => 'required|digits:11|min:11|max:11',
            'birthDate' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'role_id' => 'required',
        ]);
        $date = $request->birthDate;
        $dateExplode = explode('/', $date);
//        $nowTime = Carbon::now()->setTimezone('Asia/Tehran')->format('H:m:s');
        $jalaliArrayDate = Verta::jalaliToGregorian($dateExplode[0], $dateExplode[1], $dateExplode[2]);
        $jalaliStringDate = $jalaliArrayDate[0] . '-' . $jalaliArrayDate[1] . '-' . $jalaliArrayDate[2];
        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'password' => Hash::make($request->password),
            'image' => $request->image,
            'nationalCode' => $request->nationalCode,
            'mobile' => $request->mobile,
            'homeNumber' => $request->homeNumber,
            'birthDate' => $jalaliStringDate,
            'email' => $request->email,
            'address' => $request->address,
        ])->syncRoles($request->role_id);
        $wallet = Wallet::create([
            'user_id' => $user->id,
            'money' => 0,
        ]);
        $dashboard_setting = Dashboardsetting::create([
            'user_id' => $user->id,
            'email_notification' => 0,
            'new_order_accept_sms' => 0,
            'new_order_cancel_sms' => 0,
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
    public function edit(User $user)
    {
        if (!auth()->user()->hasPermissionTo('edit user')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $userRole = $user->roles->pluck('id');
        $roleData = RoleResource::collection(Role::latest()->get());
        return Inertia::render('Users/Edit', compact('user', 'roleData', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!auth()->user()->hasPermissionTo('update user')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        if ($request->password == '') {
            $request->validate([
                'username' => 'required|max:255',
                'fullname' => 'required|max:255',
                'image' => 'required',
                'nationalCode' => 'required|digits:10',
                'mobile' => 'required|digits:11',
                'homeNumber' => 'required|digits:11',
                'birthDate' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'role_id' => 'required',
            ]);
            $date = $request->birthDate;
            $dateExplode = [];
            if (str_contains($date, '/')) {
                $dateExplode = explode('/', $date);
            } else {
                $dateExplode = explode('-', $date);
            }
//        $nowTime = Carbon::now()->setTimezone('Asia/Tehran')->format('H:m:s');
            $jalaliArrayDate = Verta::jalaliToGregorian($dateExplode[0], $dateExplode[1], $dateExplode[2]);
            $jalaliStringDate = $jalaliArrayDate[0] . '-' . $jalaliArrayDate[1] . '-' . $jalaliArrayDate[2];
            $user->update([
                'username' => $request->username,
                'fullname' => $request->fullname,
                'image' => $request->image,
                'nationalCode' => $request->nationalCode,
                'mobile' => $request->mobile,
                'homeNumber' => $request->homeNumber,
                'birthDate' => $jalaliStringDate,
                'email' => $request->email,
                'address' => $request->address,
            ]);
            $user->syncRoles($request->role_id);
        } else {
            $request->validate([
                'username' => 'required|max:255',
                'fullname' => 'required|max:255',
                'password' => 'required|min:8',
                'image' => 'required',
                'nationalCode' => 'required|min:10|max:10',
                'mobile' => 'required|min:11|max:11',
                'homeNumber' => 'required|min:11|max:11',
                'birthDate' => 'required',
                'email' => 'required|email',
                'address' => 'required',
            ]);
            $date = $request->birthDate;
            $dateExplode = [];
            if (str_contains($date, '/')) {
                $dateExplode = explode('/', $date);
            } else {
                $dateExplode = explode('-', $date);
            }
//        $nowTime = Carbon::now()->setTimezone('Asia/Tehran')->format('H:m:s');
            $jalaliArrayDate = Verta::jalaliToGregorian($dateExplode[0], $dateExplode[1], $dateExplode[2]);
            $jalaliStringDate = $jalaliArrayDate[0] . '-' . $jalaliArrayDate[1] . '-' . $jalaliArrayDate[2];
            $user->update([
                'username' => $request->username,
                'fullname' => $request->fullname,
                'password' => Hash::make($request->password),
                'image' => $request->image,
                'nationalCode' => $request->nationalCode,
                'mobile' => $request->mobile,
                'homeNumber' => $request->homeNumber,
                'birthDate' => $jalaliStringDate,
                'email' => $request->email,
                'address' => $request->address,
            ]);
            $user->syncRoles($request->roleid);
        }
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->hasPermissionTo('delete user')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        if (auth()->user() === $user)
            return response()->json(100);
        $user->delete();
        return response()->json(200);
    }
}
