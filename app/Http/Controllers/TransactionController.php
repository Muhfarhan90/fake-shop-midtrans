<?php

namespace App\Http\Controllers;

use App\Mail\TransactionInvoiceMail;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function index()
    {

        $transactions = Transaction::where('user_id', Auth::user()->id)->get();

        $transactions->transform(function ($transaction, $key) {
            $transaction->product = collect(config('products'))->firstWhere('id', $transaction->product_id);
            return $transaction;
        });


        return view('transactions', compact('transactions'));
    }

    public function exportPdf($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaction not found');
        };

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        try {
            // Ambil status pembayaran dari Midtrans
            $paymentStatus = \Midtrans\Transaction::status($transaction->id);
            // dd($paymentStatus);
            // Kirim data transaksi dan status pembayaran ke view PDF
            $pdf = Pdf::loadView('pdf.invoice', ['transaction' => $transaction, 'paymentStatus' => $paymentStatus])->output();

            // Kirim email dengan lampiran PDF
            Mail::to($transaction->user->email)->send(new TransactionInvoiceMail($transaction, $pdf));

            return redirect()->back()->with('success', 'Invoice berhasil dikirim ke email pelanggan');

            // Set header untuk download PDF
            // return $pdf->download('invoice-' . $transaction->id . '-' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tampilkan pesan error
            dd($e);
            return redirect()->back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }
    public function testEmail()
    {
        $details = [
            'title' => 'Test Email',
            'body' => 'This is a test email sent using Mailtrap.'
        ];

        Mail::send('emails.test', $details, function ($message) {
            $message->to('recipient@example.com')
                ->subject('Test Email from Laravel');
        });

        return 'Email sent successfully!';
    }
}
