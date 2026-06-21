@extends('main')

@section('title', 'Login')

@section('bodyClass', 'auth-page')

@section('content')

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-logo">
                SO
            </div>

            <span class="section-label">
                Service Management
            </span>

            <h1>Welcome back</h1>

            <p>
                Enter your account details to access the management system.
            </p>
        </div>

        <form method="POST" action="/login" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">
                    Email address
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email address"
                    autocomplete="email"
                    autofocus
                >

                @error('email')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                >

                @error('password')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Login
            </button>
        </form>

        <div class="auth-footer">
            <a href="/forgotPassword">
                Forgot your password?
            </a>
        </div>
    </div>
</div>

@endsection