@extends('main')

@section('content')

<h1>Edit User</h1>

<form method="POST" action="/admin/users/edit/{{ $model->id }}">
    @csrf

    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $model->name) }}">

    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $model->email) }}">

    @error('email')
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
        Leave password fields empty if you do not want to change the password.
    </div>

    <label>Security Question</label>
    <input type="text"
           name="SecurityQuestion"
           value="{{ old('SecurityQuestion', $model->SecurityQuestion) }}">

    @error('SecurityQuestion')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>New Security Answer</label>
    <input type="text"
           name="SecurityAnswer"
           placeholder="Leave empty if you do not want to change the answer">

    @error('SecurityAnswer')
        <div class="error">{{ $message }}</div>
    @enderror

    <div class="checkbox-list">
        <label class="checkbox-item">
            <input type="checkbox" name="IsActive" {{ old('IsActive', $model->IsActive) ? 'checked' : '' }}>
            Active user
        </label>

        <label class="checkbox-item">
            <input type="checkbox" name="IsAdmin" {{ old('IsAdmin', $model->IsAdmin) ? 'checked' : '' }}>
            Admin user
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Update User</button>
    <a href="/admin/users" class="btn btn-secondary">Back to List</a>
</form>

@endsection