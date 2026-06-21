@extends('main')

@section('bodyClass', 'auth-page')
@section('content')

<!-- The following form is used to handle the login process -->
<div class="auth-card">
    <h1>Login</h1>

    <form method="POST" action="/login">
        @csrf

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

        <button type="submit" class="btn btn-primary">Login</button>

    </form>
</div>

@endsection