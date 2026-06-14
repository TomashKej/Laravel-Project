@extends('main')

@section('content')

<h1>Edit Service Category</h1>

<!-- This form allows users to edit an existing service category by updating its title, description, and notes. 
 The form includes validation error messages for each field, and buttons to save the changes or cancel the operation.
-->
<form method="POST" action="/service-categories/edit/{{ $model->Id }}">
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

    <label>Notes</label>
    <textarea name="Notes">{{ old('Notes', $model->Notes) }}</textarea>
    @error('Notes')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="/service-categories" class="btn btn-secondary">Cancel</a>
</form>

@endsection