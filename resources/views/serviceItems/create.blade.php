@extends('main')

@section('content')

<h1>Add Service Item</h1>

<!--- Form for creating a new service item with fields for title, category, price, description, and notes --->
<form method="POST" action="/serviceItems/create">
    @csrf

    <label>Title</label>
    <input type="text" name="Title" value="{{ old('Title') }}">
    @error('Title')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Service Category</label>
    <select name="ServiceCategoryId">
        <option value="">-- Select category --</option>

        @foreach($categories as $category)
            <option value="{{ $category->Id }}" {{ old('ServiceCategoryId') == $category->Id ? 'selected' : '' }}>
                {{ $category->Title }}
            </option>
        @endforeach
    </select>
    @error('ServiceCategoryId')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Price</label>
    <input type="number" step="0.01" min="0" name="Price" value="{{ old('Price') }}">
    @error('Price')
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
    <a href="/serviceItems" class="btn btn-secondary">Cancel</a>
</form>

@endsection