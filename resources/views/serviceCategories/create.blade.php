@extends('main')

@section('content')

<h1>Add Service Category</h1>

<!-- This form allows users to create a new service category by providing a title, description, and optional notes. 
 The form includes validation error messages for each field, and buttons to save the new category or cancel theoperation. 
-->
<form method="POST" action="/service-categories/create">
    @csrf

    <label>Title</label>
    <input type="text" name="Title" value="{{ old('Title') }}">
    @error('Title')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Description</label>
    <textarea name="Description">{{ old('Description') }}</textarea>
    @error('Description')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Notes</label>
    <textarea name="Notes">{{ old('Notes') }}</textarea>
    @error('Notes')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="/service-categories" class="btn btn-secondary">Cancel</a>
</form>

@endsection