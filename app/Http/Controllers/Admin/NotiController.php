<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class NotiController extends Controller
{
    public function noti(){
        return view('admin.noti.index');
    }

    public function send_noti(Request $request){
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filepath = 'storage/images/notifications/' . date('Y') . '/' . date('m') . '/';
            $filename = $filepath . time() . '-' . $file->getClientOriginalName();
            $file->move($filepath, $filename);
            $data['image'] = $filename;
        }
        $users = Client::all();
        $image = isset($data['image']) ? $data['image'] : null;
        notify($data['title'], $data['body'], $users, $image);
        foreach($users as $user){
            PushNotification::create([
                'title' => $data['title'],
                'body' => $data['body'],
                'image' => $image,
                'client_id' => $user->id
            ]);
        }
        return redirect(route('dashboard'))->with(
            'noti',
            Lang::get('notification.add_complain')
        );
    }
}
