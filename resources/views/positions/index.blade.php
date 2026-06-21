@extends('main')

@section('content')

<h1>Positions</h1>

<div class="page-actions">
    <a href="/positions/create" class="btn btn-primary">Add New Position</a>
</div>

<form method="GET" action="/positions" class="search-form">
    <div class="search-box">
        <input type="text"
               name="search"
               placeholder="Search positions..."
               value="{{ $search ?? '' }}">

        <button type="submit" class="btn btn-primary">Search</button>
        <a href="/positions" class="btn btn-clear">Clear</a>
    </div>
</form>

<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Employees</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($models as $position)
            <tr>
                <td>{{ $position->Title }}</td>
                <td>{{ $position->Description }}</td>
                <td>{{ $position->employees->where('IsActive', true)->count() }}</td>

                <td>
                    <div class="actions">
                        <a href="/positions/details/{{ $position->Id }}" class="btn btn-primary btn-small">
                            Details
                        </a>

                        <a href="/positions/edit/{{ $position->Id }}" class="btn btn-secondary btn-small">
                            Edit
                        </a>

                        <form method="POST" action="/positions/delete/{{ $position->Id }}" class="inline-form">
                            @csrf

                            <button type="submit"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Are you sure you want to deactivate this position?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@if($models->count() == 0)
    <p>No positions found.</p>
@endif

@endsection