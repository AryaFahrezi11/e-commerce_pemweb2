<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', 'Arial', sans-serif;
            padding: 40px;
            color: #333;
            background: #fff;
            max-width: 800px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #8B0000;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 10px;
        }

        p {
            font-size: 14px;
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: center;
        }

        th {
            background-color: #f5f5f5;
            color: #333;
        }

        .text-end {
            text-align: right;
        }

        .print-button {
            text-align: right;
            margin-bottom: 20px;
        }

        .print-button button {
            background-color: #ffc107;
            color: #000;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s ease;
        }

        .print-button button:hover {
            background-color: #000;
            color: #ffc107;
        }

        @media print {
            .print-button {
                display: none;
            }

            body {
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <div class="print-button">
        <button onclick="window.print()">🖨️ Cetak Invoice</button>
    </div>

    <h2>Invoice Pesanan</h2>

    <p><strong>No. Pesanan:</strong> #{{ $order->id }}</p>
    <p><strong>Nama:</strong> {{ $order->customer->name ?? '-' }}</p>
    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
    <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($order->items as $i => $item)
                @php
                    $subtotal = $item->price * $item->quantity;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->product->name ?? '-' }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-end"><strong>Total</strong></td>
                <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 20px; text-align: center;">Terima kasih telah berbelanja di Irish Koff and Bakery!</p>
</body>
</html>
