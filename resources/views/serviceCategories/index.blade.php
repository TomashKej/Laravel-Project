@extends('main')

@section('content')

<h1>Service Categories</h1>

<!-- This section displays a list of service categories with options to add, edit, or delete categories. 
 It also includes a search form to filter the categories based on user input. -->
<div class="page-actions">
    <a href="/serviceCategories/create" class="btn btn-primary">Add Category</a>
</div>

<!-- Search form to filter service categories based on user input. -->
<form method="GET" action="/serviceCategories" class="search-form">
    <div class="search-box">
        <input type="text" name="search" placeholder="Search categories..." value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="/serviceCategories" class="btn btn-secondary">Clear</a>
    </div>
</form>

<!-- Display the list of service categories in a table format. Each category has options to edit or delete it. -->
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($models as $category)
            <tr>
                <td>{{ $category->Title }}</td>
                <td>{{ $category->Description }}</td>
                <td>
                    <div class="actions">
                        <a href="/serviceCategories/edit/{{ $category->Id }}" class="btn btn-secondary btn-small">
                            Edit
                        </a>

                        <form method="POST" action="/serviceCategories/delete/{{ $category->Id }}" class="inline-form">
                            @csrf

                            <button type="submit"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Are you sure you want to deactivate this category?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Display a message if no service categories are found. -->
@if($models->count() == 0)
    <p>No service categories found.</p>
@endif

@endsection