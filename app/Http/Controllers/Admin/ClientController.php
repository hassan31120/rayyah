<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Client;
use App\helpers\Attachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class ClientController extends Controller
{
    public function index()
    {
        $users = Client::where('userType', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $user = Client::create($data);

        if ($request->hasFile('image')) {
            $oldFile = $user->attachmentRelation[0] ?? null;
            Attachment::updateAttachment($request->file('image'), $oldFile, $user, 'clients/images', ['save' => 'original', 'usage' => 'userImage']);
        }
        $user->save();

        return redirect(route('users'))->with(
            'Add',
            Lang::get('notification.add_user')
        );
    }

    public function edit($id)
    {
        $user = Client::find($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = Client::find($id);
        if (!$user) {
            return back()->with(
                'error',
                'errrrrrrrrrrrrrror'
            );
        }
        $data = $request->validated();
        $user->update($data);

        if ($request->hasFile('image')) {
            $oldFile = $user->attachmentRelation[0] ?? null;
            Attachment::updateAttachment($request->file('image'), $oldFile, $user, 'products/images', ['save' => 'original', 'usage' => 'userImage']);
        }
        $user->save();

        return redirect(route('users'))->with(
            'edit',
            Lang::get('notification.edit_user')
        );
    }

    public function destroy(string $id)
    {
        $user = Client::find($id);
        if (!$user) {
            return back()->with(
                'error',
                'errrrrrrrrrrrrrror'
            );
        }
        $user->delete();
        return redirect(route('users'))->with(
            'delete',
            Lang::get('notification.del_user')
        );
    }
}
