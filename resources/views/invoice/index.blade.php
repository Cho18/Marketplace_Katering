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
                        <td width="220"><strong>Tanggal Invoice</strong></td>
                        <td width="20">:</td>
                        <td>{{ $invoice->invoice_date }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Amount</strong></td>
                        <td>:</td>
                        <td>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Porsi</strong></td>
                        <td>:</td>
                        <td>{{ $invoice->order->quantity }}</td>
                    </tr>
                    <tr>
                        <td><strong>Menu</strong></td>
                        <td>:</td>
                        <td>{{ $invoice->order->menu->name }}</td>
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
                    <tr>
                        <td><strong>Nama Pemesan</strong></td>
                        <td>:</td>
                        <td>{{ $invoice->order->user->name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-primary">Kembali ke Daftar Pesanan</a>
</div>

@endsection
