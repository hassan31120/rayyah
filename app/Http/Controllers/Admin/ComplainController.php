<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ComplainController extends Controller
{
    public function index()
    {
        $complains = Complain::all();
        return view('admin.complains.index', compact('complains'));
    }

    public function destroy($id)
    {
        $complain = Complain::find($id);
        if (!$complain) {
            return back()->with(
                'error',
                'errrrrrrrrrrrrrror'
            );
        }
        $complain->delete();
        return redirect(route('complains'))->with(
            'delete',
            Lang::get('notification.del_complain')
        );
    }
}
