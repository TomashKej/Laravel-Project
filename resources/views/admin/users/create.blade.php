@extends('main')

@section('content')

<h1>Add New User</h1>

<form method="POST" action="/admin/users/create">
    @csrf

    <label>Name</label>
    <input type="text" name="name" value="{{ old('name') }}">

    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}">

    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Password</label>
    <input type="password" name="password">

    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Confirm Password</label>
    <input type="password" name="password_confirmation">

    <div class="password-rules">
        Password must contain at least 8 characters, uppercase and lowercase letters, number and symbol.
    </div>

    <label>Security Question</label>
    <input type="text"
           name="SecurityQuestion"
           value="{{ old('SecurityQuestion') }}"
           placeholder="Example: What is your favourite car brand?">

    @error('SecurityQuestion')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Security Answer</label>
    <input type="text"
           name="SecurityAnswer"
           value="{{ old('SecurityAnswer') }}"
           placeholder="Example: Honda">

    @error('SecurityAnswer')
        <div class="error">{{ $message }}</div>
    @enderror

    <div class="checkbox-list">
        <label class="checkbox-item">
            <input type="checkbox" name="IsActive" checked>
            Active user
        </label>

        <label class="checkbox-item">
            <input type="checkbox" name="IsAdmin">
            Admin user
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Create User</button>
    <a href="/admin/users" class="btn btn-secondary">Back to List</a>
</form>

@endsection