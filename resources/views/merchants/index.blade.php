@extends('dashboard.index')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Daftar Katering</h1>
    <div class="row mb-3">
        <div class="col-md-6 offset-md-3">
            <form action="{{ route('merchants.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari katering" value="{{ request()->input('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <table id="merchantsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Katering</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
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
</div>
@endsection
