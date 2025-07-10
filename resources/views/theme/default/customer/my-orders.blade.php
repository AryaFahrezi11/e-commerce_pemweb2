<x-layout>
    <x-slot name="title">Pesanan Saya</x-slot>

    <style>
        body, html {
            margin: 0;
            padding: 50;
            background: linear-gradient(135deg, #4a0000, #8B0000);
            min-height: 100vh;
        }

        h2, .card-header, strong, label {
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

        .card-header {
            background: rgba(0, 0, 0, 0.4);
            font-weight: 600;
            text-align: center;
            font-size: 1rem;
            padding: 12px 0;
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

        .table tbody tr {
            background-color: #ffffff;
            color: #222;
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(255, 193, 7, 0.15);
        }

        .table tbody td {
            text-align: center;
            font-size: 0.9rem;
            padding: 10px;
            border-bottom: 1px solid #eaeaea;
        }

        .status-badge {
            text-transform: capitalize;
            font-size: 0.8rem;
            padding: 5px 10px;
        }

        .btn {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 6px;
            transition: 0.3s ease;
        }

        .btn-outline-warning {
            color: #ffc107;
            border: 1px solid #ffc107;
            background: transparent;
        }

        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #000;
        }

        .btn-outline-danger {
            color: #dc3545;
            border: 1px solid #dc3545;
            background: transparent;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .order-actions {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .alert-warning {
            background: rgba(0, 0, 0, 0.4);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.2);
            border-radius: 8px;
            padding: 10px;
        }
    </style>

    <div class="container my-5">
        <h2 class="mb-4 text-center"><i class="bi bi-box-seam-fill"></i> Pesanan Saya</h2>

        @if(empty($orders) || count($orders) === 0)
            <div class="alert alert-warning text-center">
                Anda belum memiliki pesanan.
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    Riwayat Pesanan Anda
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    @php
                                        $status = strtolower($order['status'] ?? 'pending');
                                        $badgeColor = match($status) {
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            'pending' => 'warning',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <tr>
                                        <td>#{{ $order['order_id'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-Y') }}</td>
                                        <td>Rp {{ number_format($order['total_amount'], 0, ',', '.') }}</td>
                                        <td>{{ $order['payment_method'] ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $badgeColor }} status-badge">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="order-actions">
                                            <a href="{{ route('customer.order_details', $order['order_id']) }}" class="btn btn-outline-warning btn-sm">
                                                Detail
                                            </a>
                                            @if($status === 'pending')
                                                <form method="POST" action="{{ route('customer.order_cancel', $order['order_id']) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        Batal
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout>
