<x-layout>
    <x-slot name="title">Order Details</x-slot>

    <style>
        body, html {
            margin: 0;
            padding: 50;
            background: linear-gradient(135deg, #4a0000, #8B0000);
            min-height: 100vh;
        }

        h3, strong, label {
            color: #ffc107 !important;
        }

       .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 193, 7, 0.2);
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.3);
        }

        .card-body p {
            margin: 6px 0;
            font-size: 0.95rem;
            color: #ffffff;
        }

        .badge {
            font-size: 0.8rem;
            padding: 6px 14px;
            font-weight: 600;
            border-radius: 6px;
        }

        .badge-completed {
            background-color: #198754;
            color: #fff;
        }

        .badge-cancelled {
            background-color: #dc3545;
            color: #fff;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 8px;
            margin-top: 10px;
        }

       .table thead th {
            background-color: #3a0000;
            color: #ffc107;
            text-align: center;
            font-size: 0.9rem;
            padding: 10px;
        }

        .table tbody td {
            text-align: center;
            padding: 12px;
            background-color: #ffffff;
            color: #333;
            font-size: 0.9rem;
            border-bottom: 1px solid #f1e4b3;
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover td {
            background-color: #fff7e6;
        }

        .table tfoot td {
            background-color: #ffffff;
            color: #ffc107;
            font-weight: bold;
            text-align: right;
            padding: 12px;
        }

        .btn-print {
            background-color: #ffc107;
            color: #000;
            border: none;
            padding: 6px 12px;
            font-weight: 600;
            border-radius: 6px;
            transition: 0.3s ease;
        }

        .btn-print:hover {
            background-color: #000;
            color: #ffc107;
        }

        .btn-danger {
            background: transparent;
            color: #dc3545;
            border: 1px solid #dc3545;
            font-size: 0.9rem;
            padding: 6px 12px;
            transition: 0.3s ease;
            border-radius: 6px;
            margin-top: 15px;
        }

        .btn-danger:hover {
            background: #dc3545;
            color: #fff;
        }

        .btn-back {
            background-color: transparent;
            border: 1px solid #ffc107;
            color: #ffc107;
            font-size: 0.9rem;
            padding: 6px 12px;
            font-weight: 600;
            border-radius: 6px;
            margin-top: 20px;
            display: inline-block;
            transition: 0.3s ease;
        }

        .btn-back:hover {
            background-color: #ffc107;
            color: #000;
        }
    </style>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-4 text-center"><i class="bi bi-journal-text"></i> Order Details #{{ $order->id }}</h3>
            <a href="{{ route('customer.order_invoice', $order->id) }}" target="_blank" class="btn btn-print btn-sm">
                🧾 Print Receipt
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <p><strong>Order Date:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Status:</strong>
                    @php
                        $badgeClass = match($order->status) {
                            'completed' => 'badge-completed',
                            'cancelled' => 'badge-cancelled',
                            'pending' => 'badge-pending',
                            default => 'badge-secondary',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Sub-Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($order->items as $item)
                            @php
                                $subtotal = $item->price * $item->quantity;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $item->product->name ?? '-' }}</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">Total</td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>

                @if($order->status === 'pending')
                    <form method="POST" action="{{ route('customer.order_cancel', $order->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Cancel Order
                        </button>
                    </form>
                @endif

                <a href="{{ route('orders.index') }}" class="btn btn-back">
                    🔙 Kembali ke My Order
                </a>
            </div>
        </div>
    </div>
</x-layout>
