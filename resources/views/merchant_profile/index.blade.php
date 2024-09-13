@extends('dashboard.index')

@section('content')

<div class="container mt-5">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Merchant Profile</h4>
                <form action="{{ route('merchant.profile.update') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" value="{{ old('company_name', $profile->company_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ old('address', $profile->address) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" name="contact" value="{{ old('contact', $profile->contact) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4">{{ old('description', $profile->description) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>


@endsection