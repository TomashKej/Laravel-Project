@extends('main')

@section('title', 'Reset Password')

@section('bodyClass', 'auth-page')

@section('content')

<div class="auth-wrapper">
    <div class="auth-card auth-card-wide">
        <div class="auth-card-header">
            <div class="auth-logo">
                ✓
            </div>

            <span class="section-label">
                Account recovery
            </span>

            <h1>Reset Password</h1>

            <p>
                Answer your security question and create a new password
                for your account.
            </p>
        </div>

        <form
            method="POST"
            action="/forgotPassword/reset"
            class="auth-form"
        >
            @csrf

            <input
                type="hidden"
                name="email"
                value="{{ $email }}"
            >

            <div class="form-group">
                <label for="display-email">
                    Email address
                </label>

                <input
                    id="display-email"
                    type="email"
                    value="{{ $email }}"
                    disabled
                    class="input-disabled"
                >
            </div>

            <div class="form-group">
                <label for="security-question">
                    Security question
                </label>

                <input
                    id="security-question"
                    type="text"
                    value="{{ $securityQuestion }}"
                    disabled
                    class="input-disabled"
                >
            </div>

            <div class="form-group">
                <label for="SecurityAnswer">
                    Security answer
                </label>

                <input
                    id="SecurityAnswer"
                    type="password"
                    name="SecurityAnswer"
                    value="{{ old('SecurityAnswer') }}"
                    placeholder="Enter your security answer"
                    autocomplete="off"
                >

                @error('SecurityAnswer')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">
                    New password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Enter your new password"
                    autocomplete="new-password"
                >

                @error('password')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Confirm new password
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Enter your new password again"
                    autocomplete="new-password"
                >
            </div>

            <div class="password-rules">
                <strong>Password requirements</strong>

                <span>
                    Use at least 8 characters, including uppercase and lowercase
                    letters, a number and a special character.
                </span>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Change Password
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