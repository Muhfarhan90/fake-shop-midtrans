<!DOCTYPE html>
<html>

<head>
    <title>Invoice Transaksi</title>
</head>

<body>
    <h1>Invoice Transaksi</h1>
    <div>
        <div>
            <p>ID Transaksi: {{ $transaction->id }}</p>
            <p>Harga: Rp{{ number_format($transaction->price, 0, ',', '.') }}</p>
            <p>Status: {{ ucfirst($transaction->status) }}</p>
            <p>Tanggal: {{ $transaction->created_at }}</p>

        </div>
        <div>
            <p>Metode Pembayaran: {{ $paymentStatus->payment_type }}</p>
            <p>Nama: {{ $transaction->user->name }}</p>
            <p>Email: {{ $transaction->user->email }}</p>
            <p>Waktu Pembayaran: {{ $paymentStatus->transaction_time }}</p>
            <p>Bank: {{ $paymentStatus->va_numbers[0]->bank ?? 'N/A' }}</p>
            <p>VA Number: {{ $paymentStatus->va_numbers[0]->va_number ?? 'N/A' }}</p>
        </div>
    </div>

</body>

</html>
