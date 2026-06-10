<?php

namespace App\Mail;

use App\Models\PropertyInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPropertyInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PropertyInquiry $inquiry)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle demande de visite - ' . ($this->inquiry->property->title ?? 'Bien immobilier'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.property-inquiries.new',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}