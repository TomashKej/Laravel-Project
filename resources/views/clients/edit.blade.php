@extends('main')

@section('content')

@php

    /* 
    Prepare the date of birth value for the input field, ensuring it is in the correct format (YYYY-MM-DD) for the date input type. 
    If there is an old input value (from a previous form submission), use that; otherwise, use the model's date of birth, formatted appropriately. 
    If the model's date of birth is null, default to an empty string.
    */

    $dateOfBirth = old(
        'DateOfBirth',
        $model->DateOfBirth ? \Carbon\Carbon::parse($model->DateOfBirth)->format('Y-m-d') : ''
    );
@endphp

<h1>Edit Client</h1>

<!-- 
    The following code creates a form to edit an existing client with fields for first name, last name, date of birth, email, phone, address, city, postcode, and notes. 
    It also includes validation error messages for each field.
-->
<form method="POST" action="/clients/edit/{{ $model->Id }}">
    @csrf

    <label>First Name</label>
    <input type="text" name="FirstName" value="{{ old('FirstName', $model->FirstName) }}">
    @error('FirstName')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Last Name</label>
    <input type="text" name="LastName" value="{{ old('LastName', $model->LastName) }}">
    @error('LastName')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Date of Birth</label>
    <input type="date" name="DateOfBirth" value="{{ $dateOfBirth }}">
    @error('DateOfBirth')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Email</label>
    <input type="email" name="Email" value="{{ old('Email', $model->Email) }}">
    @error('Email')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Phone</label>
    <input type="text" name="Phone" value="{{ old('Phone', $model->Phone) }}">
    @error('Phone')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Address</label>
    <input type="text" name="Address" value="{{ old('Address', $model->Address) }}">
    @error('Address')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>City</label>
    <input type="text" name="City" value="{{ old('City', $model->City) }}">
    @error('City')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Postcode</label>
    <input type="text" name="PostCode" value="{{ old('PostCode', $model->PostCode) }}">
    @error('PostCode')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Notes</label>
    <textarea name="Notes">{{ old('Notes', $model->Notes) }}</textarea>
    @error('Notes')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="/clients" class="btn btn-secondary">Cancel</a>
</form>

@endsection