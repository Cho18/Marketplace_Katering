@extends('dashboard.index')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Tambah Menu Makanan</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="type_of_food">Jenis Menu Makanan</label>
                <select name="type_of_food" class="form-control" required>
                    <option value="">--Pilih Jenis Makanan--</option>
                    <option value="nasi goreng">Nasi Goreng</option>
                    <option value="ayam goreng">Ayam Goreng</option>
                    <option value="mie goreng">Mie Goreng</option>
                    <option value="lontong">Lontong</option>
                    <option value="nasi ayam">Nasi Ayam</option>
                </select>
            </div>
            <div class="form-group mt-3">
                <label for="name">Nama Menu Makanan</label>
                <input type="text" name="name" placeholder="nama menu makanan" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label for="description">Deskripsi</label>
                <textarea name="description" placeholder="deskripsi menu makanan" class="form-control" required></textarea>
            </div>

            <div class="form-group mt-3">
                <label for="price">Harga</label>
                <input type="number" step="0.01" name="price" placeholder="harga menu makanan" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label for="photo">Gambar</label>
                <input type="file" name="photo" class="form-control" required>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('menu.index') }}" class="btn btn-danger me-2">Kembali</a>
                <button type="submit" class="btn btn-success">Tambah Menu</button>
            </div>
        </form>
    </div>
@endsection
