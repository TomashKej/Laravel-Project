@extends('main')

@section('content')

<h1>Service Items</h1>

<!----- 
This section displays a list of service items with options to add, edit, and delete them. 
It also includes a search form to filter the service items based on user input. 
----->
<div class="page-actions">
    <a href="/serviceItems/create" class="btn btn-primary">Add Service Item</a>
</div>

<form method="GET" action="/serviceItems" class="search-form">
    <div class="search-box">
        <input type="text" name="search" placeholder="Search service items..." value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="/serviceItems" class="btn btn-secondary">Clear</a>
    </div>
</form>

<!--- Table displaying the list of service items with their details and actions --->
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Price</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($models as $serviceItem)
            <tr>
                <td>{{ $serviceItem->Title }}</td>
                <td>{{ $serviceItem->serviceCategory->Title ?? 'No category' }}</td>
                <td>£{{ number_format($serviceItem->Price, 2) }}</td>
                <td>{{ $serviceItem->Description }}</td>
                <td>
                    <div class="actions">

                        <a href="/serviceItems/details/{{ $serviceItem->Id }}" class="btn btn-primary btn-small">
                            Details
                        </a>

                        <a href="/serviceItems/edit/{{ $serviceItem->Id }}" class="btn btn-secondary btn-small">
                            Edit
                        </a>

                        <form method="POST" action="/serviceItems/delete/{{ $serviceItem->Id }}" class="inline-form">
                            @csrf

                            <button type="submit"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Are you sure you want to deactivate this service item?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!--- Display a message if no service items are found --->
@if($models->count() == 0)
    <p>No service items found.</p>
@endif

@endsection