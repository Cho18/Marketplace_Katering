@extends('dashboard.index')

@section('content')

<div class="container mt-5">
    <h2 class="text-center mb-4">Detail Invoice</h2>

    <div class="card mb-4">
        <div class="card-header">
            Invoice #{{ $invoice->invoice_number }}
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td width="220"><strong>Nama Pemesan</strong></td>
                        <td width="20">:</td>
                        <td>{{ $invoice->order->user->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Katering</strong></td>
                        <td>:</td>
                        <td>{{ $invoice->order->menu->merchant->company_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Pesanan</strong></td>
                        <td>:</td>
                        <td>{{ $invoice->invoice_date }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Menu Makanan</strong></td>
                        <td>:</td>
                        <td>{{ $invoice->order->menu->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Pesanan</strong></td>
                        <td>:</td>
                        <td>{{ $invoice->order->quantity }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Harga</strong></td>
                        <td>:</td>
                        <td>Rp {{ number_format($invoice->order->menu->price * $invoice->order->quantity, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Pengiriman</strong></td>
                        <td>:</td>
                        <td>{{ $invoice->order->delivery_date }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jam Pengiriman</strong></td>
                        <td>:</td>
                        <td>{{ $invoice->order->delivery_time }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('orders.index') }}" class="btn btn-primary">Kembali ke Daftar Pesanan</a>
    </div>
</div>

@endsection
