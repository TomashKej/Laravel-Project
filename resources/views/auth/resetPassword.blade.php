@extends('main')

@section('bodyClass', 'auth-page')

@section('content')

<div class="auth-card">
    <h1>Reset Password</h1>

    <form method="POST" action="/forgotPassword/reset">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">

        <label>Email</label>
        <input type="email" value="{{ $email }}" disabled>

        <label>Security Question</label>
        <input type="text" value="{{ $securityQuestion }}" disabled>

        <label>Security Answer</label>
        <input type="password" name="SecurityAnswer" value="{{ old('SecurityAnswer') }}">

        @error('SecurityAnswer')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>New Password</label>
        <input type="password" name="password">

        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Confirm New Password</label>
        <input type="password" name="password_confirmation">

        <div class="password-rules">
            Password must contain at least 8 characters, uppercase and lowercase letters, number and symbol.
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>
        <a href="/login" class="btn btn-secondary">Back to Login</a>
    </form>
</div>

@endsection