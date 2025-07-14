<x-layout>
    <x-slot name="title">Pesanan Saya</x-slot>

    <!-- Styles tetap tidak diubah -->
    <style>
        /* ... (semua style tetap) ... */
    </style>

    <div class="container my-5">
        <h2 class="mb-4 text-center"><i class="bi bi-box-seam-fill"></i> Pesanan Saya</h2>

        @if($orders->isEmpty())
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
                                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td>{{ $order->payment_method ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $badgeColor }} status-badge">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="order-actions">
                                            <a href="{{ route('customer.order_show', $order->id) }}" class="btn btn-outline-warning btn-sm">
                                                Detail
                                            </a>
                                            @if($status === 'pending')
                                                <form method="POST" action="{{ route('customer.order_cancel', $order->id) }}">
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
