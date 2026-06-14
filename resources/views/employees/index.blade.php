@extends('main')

@section('content')

<h1>Employees</h1>

<!-- This section displays a list of employees with options to add, edit, or delete them. It also includes a search form to filter employees based on the search query. -->
<div class="page-actions">
    <a href="/employees/create" class="btn btn-primary">Add Employee</a>
</div>

<form method="GET" action="/employees" class="search-form">
    <div class="search-box">
        <input type="text" name="search" placeholder="Search employees..." value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="/employees" class="btn btn-secondary">Clear</a>
    </div>
</form>

<!-- This table displays the list of employees with their details and actions to edit or delete them. -->
<table>
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Position</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($models as $employee)
            <tr>
                <td>{{ $employee->FirstName }}</td>
                <td>{{ $employee->LastName }}</td>
                <td>{{ $employee->Email }}</td>
                <td>{{ $employee->Phone }}</td>
                <td>{{ $employee->Position }}</td>
                <td>
                    <div class="actions">
                        <a href="/employees/edit/{{ $employee->Id }}" class="btn btn-secondary btn-small">
                            Edit
                        </a>

                        <form method="POST" action="/employees/delete/{{ $employee->Id }}" class="inline-form">
                            @csrf

                            <button type="submit"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Are you sure you want to deactivate this employee?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- This section displays a message when no employees are found. -->
@if($models->count() == 0)
    <p>No employees found.</p>
@endif

@endsection