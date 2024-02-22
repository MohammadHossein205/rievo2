<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class GalleryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index galleries')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $galleries = GalleryResource::collection(Gallery::latest()->paginate(12));
        return Inertia::render('Gallery/Index', compact('galleries'));
    }

    public function GetGalleriesData()
    {
        if (!auth()->user()->hasPermissionTo('index galleries')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        return GalleryResource::collection(Gallery::latest()->paginate(21));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create gallery')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
//        $request->validate([
//            'image' => 'required|file|max:2048'
//        ]);
        $image = $request->file('image');
        $name = $image->getClientOriginalName();
        $format = $image->getClientOriginalExtension();
        $changename = rand(1, 999999) . $name;
        $url = '/upload/image';
        $path = $_SERVER['DOCUMENT_ROOT'] . $url;
        $final = $image->move($path, $changename);
        $size = $final->getSize();

        $gallery = Gallery::create([
            'user_id' => Auth::id(),
            'name' => $changename,
            'size' => $size,
            'path' => "$path/$changename",
            'url' => "$url/$changename",
            'format' => $format,
        ]);
        return $gallery;
    }

    public function destroy(Gallery $gallery)
    {
        if (!auth()->user()->hasPermissionTo('delete gallery')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $gallery_path = $gallery->path;
        if ($gallery->delete()) {
            File::delete($gallery_path);
        }
        return response()->json(200);
    }
}
