@extends('dashboard.index')

@section('content')
@if(Auth::user()->role_id == 2)
<div class="container">
    <h1>Edit Menu Item</h1>

    <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="type_of_food">Type of Food</label>
            <select name="type_of_food" class="form-control" required>
                <option value="nasi goreng" {{ $menu->type_of_food == 'nasi goreng' ? 'selected' : '' }}>Nasi Goreng</option>
                <option value="ayam goreng" {{ $menu->type_of_food == 'ayam goreng' ? 'selected' : '' }}>Ayam Goreng</option>
                <option value="mie goreng" {{ $menu->type_of_food == 'mie goreng' ? 'selected' : '' }}>Mie Goreng</option>
                <option value="lontong" {{ $menu->type_of_food == 'lontong' ? 'selected' : '' }}>Lontong</option>
                <option value="nasi ayam" {{ $menu->type_of_food == 'nasi ayam' ? 'selected' : '' }}>Nasi Ayam</option>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Menu Name</label>
            <input type="text" name="name" value="{{ $menu->name }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $menu->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" value="{{ $menu->price }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" name="photo" class="form-control">
            <img src="{{ asset('storage/' . $menu->photo) }}" width="100" alt="{{ $menu->name }}">
        </div>

        <button type="submit" class="btn btn-success">Update Menu Item</button>
    </form>
</div>
@endif
@endsection
