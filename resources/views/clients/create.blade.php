@extends('main')

@section('content')

<h1>Add Client</h1>

<!-- 
    The following code creates a form to add a new client with fields for first name, last name, date of birth, email, phone, address, city, postcode, and notes. 
    It also includes validation error messages for each field.
-->
<form method="POST" action="/clients/create">
    @csrf

    <label>First Name</label>
    <input type="text" name="FirstName" value="{{ old('FirstName') }}">
    @error('FirstName')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Last Name</label>
    <input type="text" name="LastName" value="{{ old('LastName') }}">
    @error('LastName')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Date of Birth</label>
    <input type="date" name="DateOfBirth" value="{{ old('DateOfBirth') }}">
    @error('DateOfBirth')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Email</label>
    <input type="email" name="Email" value="{{ old('Email') }}">
    @error('Email')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Phone</label>
    <input type="text" name="Phone" value="{{ old('Phone') }}">
    @error('Phone')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Address</label>
    <input type="text" name="Address" value="{{ old('Address') }}">
    @error('Address')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>City</label>
    <input type="text" name="City" value="{{ old('City') }}">
    @error('City')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Postcode</label>
    <input type="text" name="PostCode" value="{{ old('PostCode') }}">
    @error('PostCode')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Notes</label>
    <textarea name="Notes">{{ old('Notes') }}</textarea>
    @error('Notes')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="/clients" class="btn btn-secondary">Cancel</a>
</form>

@endsection