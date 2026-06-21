<?php

namespace App\Services;

use App\Mail\AdminQuotationNotification;
use App\Mail\QuotationCreatedMail;
use App\Models\Contact;
use App\Models\Quotation;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendQuotationEmails(Quotation $quotation): void
    {
        Mail::to($quotation->email)->send(new QuotationCreatedMail($quotation));

        $adminEmail = $this->resolveAdminEmail();

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new AdminQuotationNotification($quotation));
        }
    }

    protected function resolveAdminEmail(): ?string
    {
        $contact = Contact::first();

        if ($contact && $contact->email) {
            return $contact->email;
        }

        return config('mail.admin_email') ?? null;
    }
}
