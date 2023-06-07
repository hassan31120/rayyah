<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated =$request->validate([
            'banner_ar' => ['image'],
            'banner_en' => ['image'],

        ]);
            $data = $request->except('lang');
            $banner = new Banner();
        if ($request->hasFile('banner_ar')) {
            $file = $request->file('banner_ar');
            $filepath = 'storage/images/banners/' . date('Y') . '/' . date('m') . '/';
            $filename = $filepath . time() . '-' . $file->getClientOriginalName();
            $file->move($filepath, $filename);
            $banner->banner_ar = $filename;
            $banner->banner_en = $filename;

        }
        if ($request->hasFile('banner_en')) {
            $file = $request->file('banner_en');
            $filepath = 'storage/images/banners/' . date('Y') . '/' . date('m') . '/';
            $filename = $filepath . time() . '-' . $file->getClientOriginalName();
            $file->move($filepath, $filename);
            $banner->banner_en = $filename;


        }

        $banner->save();

        return redirect(route('banners'))->with(
            'Add',
            'added'
        );
    }
    public function destroy($id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return back()->with(
                'error',
                'errrrrrrrrrrrrrror'
            );
        }
        $filepath = $banner->banner;
        if(File::exists($filepath)) {
          File::delete($filepath);
        }
        $banner->delete();
        return redirect(route('users'))->with(
            'delete',
            'deleted'
        );
    }
}
