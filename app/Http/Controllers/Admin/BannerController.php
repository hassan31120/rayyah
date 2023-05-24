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
        $request->validate([
            'banner' => ['required']
        ]);

        $data = $request->all();

        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filepath = 'storage/images/banners/' . date('Y') . '/' . date('m') . '/';
            $filename = $filepath . time() . '-' . $file->getClientOriginalName();
            $file->move($filepath, $filename);
            $data['banner'] = $filename;
        }

        Banner::create($data);

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
