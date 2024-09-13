@extends('dashboard.index')

@section('content')
@if(Auth::user()->role_id == 2)
<div class="container">
    <h1>Add New Menu Item</h1>

    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="type_of_food">Type of Food</label>
            <select name="type_of_food" class="form-control" required>
                <option value="">--Select Type of Food--</option>
                <option value="nasi goreng">Nasi Goreng</option>
                <option value="ayam goreng">Ayam Goreng</option>
                <option value="mie goreng">Mie Goreng</option>
                <option value="lontong">Lontong</option>
                <option value="nasi ayam">Nasi Ayam</option>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Menu Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" name="photo" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Create Menu Item</button>
    </form>
</div>
@endif
@endsection
