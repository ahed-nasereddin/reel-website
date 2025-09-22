<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
class ContactController extends Controller
{
    public function show()
    {
        $contact = Contact::first();
        return new ContactResource($contact);
    }
}
