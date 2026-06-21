@extends('main')

@section('title', 'Register')

@section('bodyClass', 'auth-page')

@section('content')

<div class="auth-wrapper">
    <div class="auth-card auth-card-wide">
        <div class="auth-card-header">
            <div class="auth-logo">
                SO
            </div>

            <span class="section-label">
                Create account
            </span>

            <h1>Register</h1>

            <p>
                Create an account to access the service order management system.
            </p>
        </div>

        <form method="POST" action="/register" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="name">
                    Full name
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter your full name"
                    autocomplete="name"
                    autofocus
                >

                @error('name')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

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
                    placeholder="Create a secure password"
                    autocomplete="new-password"
                >

                <div class="password-rules">
                    <strong>Password requirements</strong>

                    <span>
                        Use at least 8 characters, including an uppercase letter,
                        lowercase letter, number and special character.
                    </span>
                </div>

                @error('password')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Confirm password
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Enter your password again"
                    autocomplete="new-password"
                >
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Create Account
            </button>
        </form>

        <div class="auth-footer">
            <p>
                Already have an account?

                <a href="/login">
                    Login
                </a>
            </p>
        </div>
    </div>
</div>

@endsection