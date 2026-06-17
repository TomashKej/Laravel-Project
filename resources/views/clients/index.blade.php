@extends('main')

@section('content')

<h1>Clients</h1>

<!-- 
    The following code displays a list of clients in a table format. 
    It includes a search form to filter clients by name, and buttons to add, edit, or delete clients. 
    If no clients are found, a message is displayed.
-->
<div class="page-actions">
    <a href="/clients/create" class="btn btn-primary">Add Client</a>
</div>

<form method="GET" action="/clients" class="search-form">
    <div class="search-box">
        <input type="text" name="search" placeholder="Search clients..." value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="/clients" class="btn btn-secondary">Clear</a>
    </div>
</form>

<!-- Display the list of clients in a table format -->
<table>
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Email</th>
            <th>Phone</th>
            <th>City</th>
            <th>Postcode</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($models as $client)
            <tr>
                <td>{{ $client->FirstName }}</td>
                <td>{{ $client->LastName }}</td>
                <td>{{ $client->DateOfBirth }}</td>
                <td>{{ $client->Email }}</td>
                <td>{{ $client->Phone }}</td>
                <td>{{ $client->City }}</td>
                <td>{{ $client->PostCode }}</td>
                <td>
                    <div class="actions">

                        <a href="/clients/details/{{ $client->Id }}" class="btn btn-primary btn-small">
                            Details
                        </a>

                        <a href="/clients/edit/{{ $client->Id }}" class="btn btn-secondary btn-small">
                            Edit
                        </a>

                        <form method="POST" action="/clients/delete/{{ $client->Id }}" class="inline-form">
                            @csrf

                            <button type="submit"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Are you sure you want to deactivate this client?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- if there are no clients, display a message -->
@if($models->count() == 0)
    <p>No clients found.</p>
@endif

@endsection