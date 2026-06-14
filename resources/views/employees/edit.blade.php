@extends('main')

@section('content')

<h1>Edit Employee</h1>

<!-- This form allows the user to edit the details of an existing employee. It includes fields for first name, last name, email, phone, position, and notes. Validation errors are displayed next to each field if applicable. -->
<form method="POST" action="/employees/edit/{{ $model->Id }}">
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

    <label>Position</label>
    <input type="text" name="Position" value="{{ old('Position', $model->Position) }}">
    @error('Position')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Notes</label>
    <textarea name="Notes">{{ old('Notes', $model->Notes) }}</textarea>
    @error('Notes')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="/employees" class="btn btn-secondary">Cancel</a>
</form>

@endsection