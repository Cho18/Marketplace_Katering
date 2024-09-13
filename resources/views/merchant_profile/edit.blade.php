<h1>Edit Profile</h1>

<form action="{{ route('merchant.profile.update') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="company_name">Company Name</label>
        <input type="text" name="company_name" value="{{ old('company_name', $profile->company_name) }}" required>
    </div>

    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" name="address" value="{{ old('address', $profile->address) }}" required>
    </div>

    <div class="form-group">
        <label for="contact">Contact</label>
        <input type="text" name="contact" value="{{ old('contact', $profile->contact) }}" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description">{{ old('description', $profile->description) }}</textarea>
    </div>

    <button type="submit">Save Changes</button>
</form>
