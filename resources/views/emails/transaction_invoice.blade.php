<!DOCTYPE html>
<html>

<head>
    <title>Invoice Transaksi</title>
</head>

<body>
    <h1>Halo, {{ $transaction->user->name }}</h1>
    <p>Terima kasih telah melakukan transaksi di FakeShop. Berikut adalah detail transaksi Anda:</p>
    <p>ID Transaksi: {{ $transaction->id }}</p>
    <p>Harga: Rp{{ number_format($transaction->price, 0, ',', '.') }}</p>
    <p>Status: {{ ucfirst($transaction->status) }}</p>
    <p>Tanggal: {{ $transaction->created_at }}</p>
    <p>Invoice transaksi Anda terlampir dalam email ini.</p>
    <p>Terima kasih!</p>
</body>

</html>
