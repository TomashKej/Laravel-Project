@extends('main')

@section('title', 'Employees')

@section('content')

<section class="list-page-header">
    <div class="list-page-heading">
        <span class="section-label">
            Employee Management
        </span>

        <h1>Employees</h1>

        <p>
            Manage employee records, contact information and assigned positions.
        </p>
    </div>

    <div class="list-page-actions">
        <a
            href="/employees/create"
            class="btn btn-primary"
        >
            Add New Employee
        </a>
    </div>
</section>


<form
    method="GET"
    action="/employees"
    class="search-form"
>
    <div class="search-box search-box-simple">
        <div class="filter-field">
            <label for="employee-search">
                Search employees
            </label>

            <input
                id="employee-search"
                type="text"
                name="search"
                placeholder="Search by name, email, telephone or position..."
                value="{{ $search ?? '' }}"
            >
        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Search
        </button>

        <a
            href="/employees"
            class="btn btn-clear"
        >
            Clear
        </a>
    </div>
</form>


@if($models->count() > 0)
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Contact Details</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($models as $employee)
                    <tr>
                        <td>
                            <div class="person-cell">
                                <span class="person-avatar">
                                    {{ strtoupper(substr($employee->FirstName, 0, 1)) }}
                                    {{ strtoupper(substr($employee->LastName, 0, 1)) }}
                                </span>

                                <div class="person-details">
                                    <span class="person-name">
                                        {{ $employee->FirstName }}
                                        {{ $employee->LastName }}
                                    </span>

                                    <span class="person-reference">
                                        Employee ID: {{ $employee->Id }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="contact-list">
                                <a
                                    href="mailto:{{ $employee->Email }}"
                                    class="contact-link"
                                >
                                    {{ $employee->Email }}
                                </a>

                                <a
                                    href="tel:{{ $employee->Phone }}"
                                    class="contact-link contact-secondary"
                                >
                                    {{ $employee->Phone }}
                                </a>
                            </div>
                        </td>

                        <td>
                            @if($employee->position || $employee->Position)
                                <span class="position-badge">
                                    {{ $employee->position->Title ?? $employee->Position }}
                                </span>
                            @else
                                <span class="table-value-empty">
                                    No position assigned
                                </span>
                            @endif
                        </td>

                        <td class="table-actions">
                            <div class="actions">
                                <a
                                    href="/employees/details/{{ $employee->Id }}"
                                    class="btn btn-primary btn-small"
                                >
                                    Details
                                </a>

                                <a
                                    href="/employees/edit/{{ $employee->Id }}"
                                    class="btn btn-outline btn-small"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="/employees/delete/{{ $employee->Id }}"
                                    class="inline-form"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-small"
                                        onclick="return confirm('Are you sure you want to deactivate this employee?')"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="list-empty-state">
        <div class="list-empty-icon">
            E
        </div>

        <h2>No employees found</h2>

        <p>
            No employees match the current search criteria.
        </p>

        <div class="page-actions">
            @if(!empty($search))
                <a
                    href="/employees"
                    class="btn btn-outline"
                >
                    Clear Search
                </a>
            @endif

            <a
                href="/employees/create"
                class="btn btn-primary"
            >
                Add New Employee
            </a>
        </div>
    </div>
@endif

@endsection