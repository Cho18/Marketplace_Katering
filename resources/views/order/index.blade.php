@extends('dashboard.index')

@section('content')

<div class="container mt-5">
    <!-- Pengecekan Role User -->
    @if(Auth::user()->role_id == 1)
        <h2 class="text-center mb-4">Daftar Pesanan Anda</h2>
        
        <!-- Menampilkan pesan sukses -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="alert alert-info">
                Anda belum memiliki pesanan.
            </div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Jumlah Porsi</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Jam Pengiriman</th>
                        <th>Harga Total</th>
                        <th>Status</th> <!-- Tambahkan kolom status -->
                        <th>Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->menu->name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->delivery_date }}</td>
                            <td>{{ $order->delivery_time }}</td>
                            <td>Rp {{ number_format($order->menu->price * $order->quantity, 0, ',', '.') }}</td>
                            <td>{{ $order->status }}</td> <!-- Menampilkan status -->
                            <td>
                                @if($order->invoice)
                                    <a href="{{ route('invoice.index', $order->invoice->id) }}" class="btn btn-info">Lihat Invoice</a>
                                @else
                                    <span class="text-muted">Belum Tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    @elseif(Auth::user()->role_id == 2)
        <h2 class="text-center mb-4">Daftar Pesanan untuk Merchant</h2>
        
        <!-- Menampilkan pesan sukses -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="alert alert-info">
                Tidak ada pesanan untuk saat ini.
            </div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemesan</th>
                        <th>Nama Menu</th>
                        <th>Jumlah Porsi</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Jam Pengiriman</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->menu->name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->delivery_date }}</td>
                            <td>{{ $order->delivery_time }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <!-- Tombol untuk membuka modal edit status -->
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal{{ $order->id }}">Edit Status</button>
                            </td>
                            <td>
                                @if($order->invoice)
                                    <a href="{{ route('invoice.index', $order->invoice->id) }}" class="btn btn-info">Lihat Invoice</a>
                                @else
                                    <span class="text-muted">Belum Tersedia</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal untuk mengedit status -->
                        <div class="modal fade" id="statusModal{{ $order->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="statusModalLabel{{ $order->id }}">Edit Status Pesanan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('orders.update.status', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="mb-3">
                                                <label for="status{{ $order->id }}" class="form-label">Pilih Status</label>
                                                <select class="form-control" id="status{{ $order->id }}" name="status">
                                                    <option value="Belum Siap" {{ $order->status == 'Belum Siap' ? 'selected' : '' }}>Belum Siap</option>
                                                    <option value="Sedang Disiapkan" {{ $order->status == 'Sedang Disiapkan' ? 'selected' : '' }}>Sedang Disiapkan</option>
                                                    <option value="Telah Siap" {{ $order->status == 'Telah Siap' ? 'selected' : '' }}>Telah Siap</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        @endif

    @else
        <div class="alert alert-danger text-center">
            Anda tidak memiliki akses untuk melihat halaman ini.
        </div>
    @endif
</div>

@endsection
