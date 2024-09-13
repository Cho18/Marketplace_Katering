@extends('dashboard.index')

@section('content')
<div class="container">
    <h1>Menu dari {{ $merchant->company_name }}</h1>

    <!-- Tombol kembali ke daftar merchant -->
    <a href="{{ route('merchants.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Katering</a>

    <!-- Search form -->
    <form action="{{ route('merchants.show', $merchant->id) }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Name, Description, Price, Type of Food" value="{{ request()->input('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <!-- Menus table -->
    <table id="menusTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Type of Food</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
            <tr>
                <td>
                    @if($menu->photo)
                        <img src="{{ asset('storage/' . $menu->photo) }}" alt="{{ $menu->name }}" width="100">
                    @else
                        No Image
                    @endif
                </td>
                <td>{{ $menu->name }}</td>
                <td>{{ $menu->description }}</td>
                <td>{{ $menu->price }}</td>
                <td>{{ $menu->type_of_food }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination links -->
    {{ $menus->withQueryString()->links() }}

</div>
@endsection

@section('scripts')
<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        $('#menusTable').DataTable({
            "paging": false, // Disable pagination in DataTables since we're using Laravel pagination
            "searching": false // Disable built-in search to use Laravel's search
        });
    });
</script>
@endsection
