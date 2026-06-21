@extends('main')

@section('content')

<h1>Add Employee</h1>

<!-- This form allows users to add a new employee by providing their details such as first name, last name, email, phone, position, and notes. It includes validation error messages for each field. -->
<form method="POST" action="/employees/create">
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

    <label>Position</label>

    <select name="PositionId">
        <option value="">Select position</option>
    
        @foreach($positions as $position)
            <option value="{{ $position->Id }}"
                {{ old('PositionId') == $position->Id ? 'selected' : '' }}>
                {{ $position->Title }}
            </option>
        @endforeach
    </select>
    
    @error('PositionId')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Notes</label>
    <textarea name="Notes">{{ old('Notes') }}</textarea>
    @error('Notes')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="/employees" class="btn btn-secondary">Cancel</a>
</form>

@endsection