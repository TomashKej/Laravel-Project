@extends('main')

@section('content')

<h1>Edit Position</h1>

<form method="POST" action="/positions/edit/{{ $model->Id }}">
    @csrf

    <label>Title</label>
    <input type="text" name="Title" value="{{ old('Title', $model->Title) }}">

    @error('Title')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Description</label>
    <textarea name="Description">{{ old('Description', $model->Description) }}</textarea>

    @error('Description')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Update Position</button>
    <a href="/positions" class="btn btn-secondary">Back to List</a>
</form>

@endsection