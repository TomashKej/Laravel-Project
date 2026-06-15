@extends('main')

@section('bodyClass', 'auth-page')
@section('content')

<!-- THE FOLLOWING FORM IS USED TO REGISTER A NEW USER -->
<div class="auth-card">

    <h1>Register</h1>

    <form method="POST" action="/register">
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

        <div class="password-rules">
            Password must contain at least 8 characters, one uppercase letter, one lowercase letter, one number and one special character.
        </div>
        
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation">

        <button type="submit" class="btn btn-primary">Register</button>
        <a href="/login" class="btn btn-secondary">Login</a>
    </form>
</div>
@endsection