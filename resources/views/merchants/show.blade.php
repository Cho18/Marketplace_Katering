@extends('dashboard.index')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Daftar Menu Makanan dari {{ $merchant->company_name }}</h1>
    <a href="{{ route('merchants.index') }}" class="btn btn-primary mt-3 mb-3">Kembali ke Daftar Katering</a>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row mb-3">
        <div class="col-md-6 offset-md-3">
            <form action="{{ route('merchants.show', $merchant->id) }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari menu makanan" value="{{ request()->input('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse ($menus as $menu)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($menu->photo)
                        <img src="{{ asset('storage/' . $menu->photo) }}" class="card-img-top" alt="{{ $menu->name }}">
                    @else
                        <img src="{{ asset('path/to/default-image.jpg') }}" class="card-img-top" alt="No Image Available">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $menu->name }}</h5>
                        <p class="card-text">{{ $menu->description }}</p>
                        <p class="card-text">Harga: Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                        <p class="card-text">Jenis Makanan: {{ $menu->type_of_food }}</p>
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#orderModal{{ $menu->id }}">Pesan</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada menu yang ditemukan.</p>
        @endforelse
    </div>

    @foreach ($menus as $menu)
    <div class="modal fade" id="orderModal{{ $menu->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $menu->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel{{ $menu->id }}">Pesan {{ $menu->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <div class="mb-3">
                            <label for="quantity{{ $menu->id }}" class="form-label">Jumlah Porsi</label>
                            <input type="number" class="form-control" id="quantity{{ $menu->id }}" name="quantity" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="delivery_date{{ $menu->id }}" class="form-label">Tanggal Pengiriman</label>
                            <input type="date" class="form-control" id="delivery_date{{ $menu->id }}" name="delivery_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="delivery_time{{ $menu->id }}" class="form-label">Jam Pengiriman</label>
                            <input type="time" class="form-control" id="delivery_time{{ $menu->id }}" name="delivery_time" required>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-success">Pesan Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
