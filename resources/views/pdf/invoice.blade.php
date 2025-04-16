<!DOCTYPE html>
<html>

<head>
    <title>Invoice Transaksi</title>
</head>

<body>
    <h1>Invoice Transaksi</h1>
    <p>ID Transaksi: {{ $transaction->id }}</p>
    <p>Harga: Rp{{ number_format($transaction->price, 0, ',', '.') }}</p>
    <p>Status: {{ ucfirst($transaction->status) }}</p>
    <p>Tanggal: {{ $transaction->created_at }}</p>
</body>

</html>
