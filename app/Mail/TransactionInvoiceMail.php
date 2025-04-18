<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class TransactionInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;


    public $transaction;
    public $pdf;
    /**
     * Create a new message instance.
     */
    public function __construct($transaction, $pdf)
    {
        //
        $this->transaction = $transaction;
        $this->pdf = $pdf;
    }

    /**
     * Get the message envelope.
     */

    public function build()
    {
        return $this->subject('Invoice Transaksi Anda')
            ->view('emails.transaction_invoice')
            ->attachData($this->pdf, 'invoice-' . $this->transaction->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Transaction Invoice Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.transaction_invoice',
            with: [
                'transaction' => $this->transaction,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    
}
