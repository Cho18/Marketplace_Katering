@extends('dashboard.index')

@section('content')

    @if(Auth::user()->role_id == 2)
        <div class="container mt-5">
            <div class="text-center mb-3">
                <h1>Daftar Menu Makanan</h1>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('menu.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Menu
                </a>
            </div>    

            <div class="mt-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <table class="table table-bordered" id="menuTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Menu Makanan</th>
                            <th>Nama Menu Makanan</th>
                            <th>Gambar</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $menu->type_of_food }}</td>
                                <td>{{ $menu->name }}</td>
                                <td><img src="{{ asset('storage/' . $menu->photo) }}" width="100"></td>
                                <td> Rp {{ $menu->price }}</td>
                                <td>{{ $menu->description }}</td>
                                <td>
                                    <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $menu->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    
                                    <div class="modal fade" id="deleteModal{{ $menu->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $menu->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $menu->id }}">Hapus Menu Makanan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah yakin menghapus menu "{{ $menu->name }}"?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif(Auth::user()->role_id == 1)
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h2 class="text-center mb-4">Daftar Menu Makanan</h2>

        <div class="row mb-3">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('menu.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari menu makanan" value="{{ request('search') }}">
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
                        <img src="{{ asset('storage/' . $menu->photo) }}" class="card-img-top" alt="{{ $menu->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->name }}</h5>
                            <p class="card-text">{{ $menu->description }}</p>
                            <p class="card-text">Harga: Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
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
@endif
@endsection
