<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index()
    {
        $settings = Setting::find(1);
        if (!$settings) {
            return view('errors.404');
        }
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $setting = Setting::find(1);
        $request->validate([
            'terms.ar' => 'required',
            'terms.en' => 'required',
            'terms.fr' => 'sometimes',
            'terms.de' => 'sometimes',
        ]);
        $data = $request->except('files');
        $setting->update($data);
        return redirect(route('settings'))->with('edit', "__('admin.update')");
    }
}
