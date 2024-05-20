<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Auth;

class ContactController extends Controller
{
    function __construct()
    {
        $this->contact = new Contact;
    }

    public function index(Request $request)
    {
        $data = $this->contact->getContacts($request->search);
        return response()->json($data);
    }

    public function create()
    {
        return view('create');
    }

    public function save(ContactRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $this->contact->addContact($data);
        return redirect()->route('home')->with('status', 'Contact added successfully');
    }

    public function edit($id)
    {
        $data = $this->contact->editContact($id);
        return view('edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'company' => '',
            'phone' => '',
            'email' => 'nullable|email|unique:contacts,email,'.$id,
        ];

        $validatedData = $request->validate($rules);
        $data = $validatedData;
        $data['user_id'] = Auth::user()->id;
        $this->contact->updateContact($id, $data);
        return redirect()->route('home')->with('status', 'Contact updated successfully');
    }

    public function delete($id)
    {
        $this->contact->deleteContact($id);
        return redirect()->route('home')->with('status', 'Contact deleted successfully');
    }

    
}
