<?php

namespace App\Http\Controllers\admin;

use App\HelperTrait\ViewPage;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Inertia\Inertia;

class AdminIndexController extends Controller
{
    use ViewPage;

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('admin index')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $data = User::latest()->first();
        return Inertia::render('index');
    }

}
