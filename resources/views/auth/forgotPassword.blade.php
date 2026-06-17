@extends('main')

@section('bodyClass', 'auth-page')

@section('content')

<div class="auth-card">
    <h1>Forgot Password</h1>

    <form method="POST" action="/forgotPassword/question">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">

        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary">Continue</button>
        <a href="/login" class="btn btn-secondary">Back to Login</a>
    </form>
</div>

@endsection