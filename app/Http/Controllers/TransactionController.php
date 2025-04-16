<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function exportPdf(Request $request)
    {
        $transaction = Transaction::find($request->id);

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaction not found');
        };

        $pdf = Pdf::loadView('pdf.invoice', ['transaction' => $transaction]);
        
        return $pdf->download('invoice-'. $transaction->id . '-' . date('Y-m-d') . '.pdf');
    }
}
