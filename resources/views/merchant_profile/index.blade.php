@extends('dashboard.index')

@section('content')

<div class="container mt-5">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title mb-4 text-center">Profil Merchant</h2>
                <form action="{{ route('merchant.profile.update') }}" method="post">
                    @csrf
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="company_name" value="{{ old('company_name', $profile->company_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="address" value="{{ old('address', $profile->address) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="contact" class="form-label">Kontak</label>
                        <input type="text" class="form-control" name="contact" value="{{ old('contact', $profile->contact) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="4">{{ old('description', $profile->description) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
