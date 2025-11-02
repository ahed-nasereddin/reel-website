<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Quotation;
use App\Models\Contact;

use App\Mail\QuotationCreatedMail;
use App\Mail\AdminQuotationNotification;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
class QuotationController extends Controller
{
    

    public function index(){
        return Inertia::render('MakeQuotation');
    }
    public function store(Request $request)
    {
        log::info('days',[$request->no_days]);
        // ✅ Validate input
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email'        => 'required|email|max:255',
            'mobile'       => 'required|string|max:20',
            'no_days'         => 'required|integer|min:1',
            'pickup_date'   => 'required|date', // "2025-09-08T14:30" → will be parsed
            'location'     => 'required|string|max:255',
            'equipments'   => 'required|array|min:1',
            'equipments.*.name'  => 'required|string|max:255',
            'equipments.*.count' => 'required|integer|min:1',
            'equipments.*.note'  => 'nullable|string|max:500',
            'notes'        => 'nullable|string|max:1000',
        ]);
        $quotation = Quotation::create([
            'name'         => $validated['name'],
            'company_name' => $validated['company_name'] ?? null,
            'email'        => $validated['email'],
            'mobile'       => $validated['mobile'],
            'no_days'         => $validated['no_days'],
            'pickup_date'  => $validated['pickup_date'],
            'location'     => $validated['location'],
            'equipments'   => $validated['equipments'], // store as JSON
            'notes'        => $validated['notes'] ?? null,
        ]);

        $contact=Contact::first();
         // Send email to customer
        Mail::to($quotation->email)->send(new QuotationCreatedMail($quotation));

        // Send email to admin
        Mail::to($contact->email)->send(new AdminQuotationNotification($quotation));
        return response()->json([
            'message' => 'Quotation created successfully!',
            'data'    => $quotation,
        ], 201);
            log::info('request',[$request->equipments]);
    }
}
