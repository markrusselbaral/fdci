<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Contact extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getContacts($search)
    {
        return $this->with('user')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->where('user_id', Auth::user()->id)
        ->paginate(2);   
    }

    public function addContact($data)
    {
        return $this->create($data);
    }

    public function editContact($id)
    {
        return $this->find($id);
    }

    public function updateContact($id, $data)
    {
        $contact = $this->find($id);
        $contact->update($data);
    }

    public function deleteContact($id)
    {
        $contact = $this->find($id);
        $contact->delete();
    }
}
