@extends('dashboard.index')

@section('content')
@if(Auth::user()->role_id == 2)
<div class="container mt-5">
    <h1 class="text-center">Edit Menu Makanan</h1>

    <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="type_of_food">Jenis Menu Makanan</label>
            <select name="type_of_food" class="form-control" required>
                <option value="nasi goreng" {{ $menu->type_of_food == 'nasi goreng' ? 'selected' : '' }}>Nasi Goreng</option>
                <option value="ayam goreng" {{ $menu->type_of_food == 'ayam goreng' ? 'selected' : '' }}>Ayam Goreng</option>
                <option value="mie goreng" {{ $menu->type_of_food == 'mie goreng' ? 'selected' : '' }}>Mie Goreng</option>
                <option value="lontong" {{ $menu->type_of_food == 'lontong' ? 'selected' : '' }}>Lontong</option>
                <option value="nasi ayam" {{ $menu->type_of_food == 'nasi ayam' ? 'selected' : '' }}>Nasi Ayam</option>
            </select>
        </div>
        <div class="form-group mt-3">
            <label for="name">Nama Menu Makanan</label>
            <input type="text" name="name" value="{{ $menu->name }}" class="form-control" required>
        </div>

        <div class="form-group mt-3">
            <label for="description">Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $menu->description }}</textarea>
        </div>

        <div class="form-group mt-3">
            <label for="price">Harga</label>
            <input type="number" step="0.01" name="price" value="{{ $menu->price }}" class="form-control" required>
        </div>

        <div class="form-group mt-3">
            <label for="photo">Gambar</label>
            <input type="file" name="photo" class="form-control">
            <img src="{{ asset('storage/' . $menu->photo) }}" class="mt-2" width="200" alt="{{ $menu->name }}">
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('menu.index') }}" class="btn btn-danger me-2">Kembali</a>
            <button type="submit" class="btn btn-success">Edit Menu</button>
        </div>
    </form>
</div>
@endif
@endsection
