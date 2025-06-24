<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin: 15px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Struk Pembayaran</h2>
        <p>No. Order: {{ $order->id }}</p>
    </div>
    
    <div class="details">
        <table>
            <tr>
                <th>Tanggal</th>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Produk</th>
                <td>{{ $order->product->name }}</td>
            </tr>
            <tr>
                <th>Total Pembayaran</th>
                <td>Rp {{ number_format($order->total_price, 2) }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $order->status === 'acc' ? 'Diterima' : ucfirst($order->status) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>