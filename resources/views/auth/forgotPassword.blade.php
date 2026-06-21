@extends('main')

@section('title', 'Forgot Password')

@section('bodyClass', 'auth-page')

@section('content')

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-logo">
                ?
            </div>

            <span class="section-label">
                Account recovery
            </span>

            <h1>Forgot Password</h1>

            <p>
                Enter the email address assigned to your account to continue
                with password recovery.
            </p>
        </div>

        <form
            method="POST"
            action="/forgotPassword/question"
            class="auth-form"
        >
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

            <button type="submit" class="btn btn-primary btn-block">
                Continue
            </button>
        </form>

        <div class="auth-footer">
            <a href="/login">
                ← Back to Login
            </a>
        </div>
    </div>
</div>

@endsection