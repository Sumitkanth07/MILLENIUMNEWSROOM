@extends('admin.layout')

@section('content')
<h2>Footer Settings</h2>
<form class="panel form" method="POST" action="{{ route('admin.footer.update') }}">
    @csrf
    <label>Company name
        <input name="company_name" value="{{ old('company_name', $footer->company_name) }}" required>
    </label>
    <label>Email
        <input name="email" type="email" value="{{ old('email', $footer->email) }}">
    </label>
    <label>Phone
        <input name="phone" value="{{ old('phone', $footer->phone) }}">
    </label>
    <label>Address
        <textarea name="address" rows="4">{{ old('address', $footer->address) }}</textarea>
    </label>
    <label>Copyright text
        <input name="copyright_text" value="{{ old('copyright_text', $footer->copyright_text) }}">
    </label>
    <button class="btn primary">Save Footer</button>
</form>
@endsection
