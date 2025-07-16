<x-layout>
    <x-slot name="title">Pesanan Saya</x-slot>

    <style>
        body, html {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #4a0000, #8B0000);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        h2, .card-header, th, td, label {
            color: white !important;
        }

        .card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            border: 1px solid rgba(255, 215, 0, 0.4);
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.4);
        }

        .table > :not(caption) > * > * {
            background-color: transparent !important;
        }

        .btn-outline-warning {
            color: #ffc107;
            border-color: #ffc107;
            transition: 0.3s ease;
        }

        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: #000;
        }

        .btn-outline-danger {
            color: #ff4d4d;
            border-color: #ff4d4d;
            transition: 0.3s ease;
        }

        .btn-outline-danger:hover {
            background-color: #ff4d4d;
            color: #fff;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.4em 0.7em;
        }

        .alert {
            border-radius: 10px;
        }
    </style>

    <div class="container my-5">
        <h2 class="mb-4 text-center"><i class="bi bi-box-seam-fill"></i> Pesanan Saya</h2>

        @if($orders->isEmpty())
            <div class="alert alert-warning text-center text-dark">
                Anda belum memiliki pesanan.
            </div>
        @else
            <div class="card">
                <div class="card-header">
                    Riwayat Pesanan Anda
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle text-white">
                            <thead class="text-warning">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    @php
                                        $status = strtolower($order->status ?? 'pending');
                                        $badgeColor = match($status) {
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            'pending' => 'warning',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td>{{ $order->payment_method ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $badgeColor }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('customer.order_show', $order->id) }}" class="btn btn-outline-warning btn-sm mb-1">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            @if($status === 'pending')
                                                <form method="POST" action="{{ route('customer.order_cancel', $order->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                        <i class="bi bi-x-circle"></i> Batal
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
