<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $contact = Contact::first(); // or whatever query you need

    return Inertia::render('Contact', [
        'contact' => (new ContactResource($contact))->resolve()
    ]);
    }
}

  
