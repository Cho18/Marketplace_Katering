@extends('dashboard.index')

@section('content')
<div class="container">
    <h1>Daftar Katering</h1>

    <!-- Search form -->
    <form action="{{ route('merchants.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Company Name, Address, Contact, Description" value="{{ request()->input('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <!-- Merchants table -->
    <table id="merchantsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($merchants as $merchant)
            <tr>
                <td>{{ $merchant->company_name }}</td>
                <td>{{ $merchant->address }}</td>
                <td>{{ $merchant->contact }}</td>
                <td>{{ $merchant->description }}</td>
                <td>
                    <a href="{{ route('merchants.show', $merchant->id) }}" class="btn btn-info">Lihat Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination links -->
    {{ $merchants->withQueryString()->links() }}

</div>
@endsection

@section('scripts')
<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        $('#merchantsTable').DataTable({
            "paging": false, // Disable pagination in DataTables since we're using Laravel pagination
            "searching": false // Disable built-in search to use Laravel's search
        });
    });
</script>
@endsection
