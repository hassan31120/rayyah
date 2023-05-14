<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Lang;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return back()->with(
                'error',
                'errrrrrrrrrrrrrror'
            );
        }
        $contact->delete();
        return redirect(route('contacts'))->with(
            'delete',
            Lang::get('notification.del_contact')
        );
    }
}
