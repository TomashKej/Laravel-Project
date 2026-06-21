@extends('main')

@section('title', 'Positions')

@section('content')

<section class="list-page-header">
    <div class="list-page-heading">
        <span class="section-label">
            Employee Management
        </span>

        <h1>Positions</h1>

        <p>
            Manage the positions available within the business and review
            how many active employees are assigned to each position.
        </p>
    </div>

    <div class="list-page-actions">
        <a
            href="/positions/create"
            class="btn btn-primary"
        >
            Add New Position
        </a>
    </div>
</section>


<form
    method="GET"
    action="/positions"
    class="search-form"
>
    <div class="search-box search-box-simple">
        <div class="filter-field">
            <label for="position-search">
                Search positions
            </label>

            <input
                id="position-search"
                type="text"
                name="search"
                placeholder="Search by title or description..."
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
            href="/positions"
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
                    <th>Position</th>
                    <th>Description</th>
                    <th>Active Employees</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($models as $position)
                    <tr>
                        <td>
                            <span class="record-title">
                                {{ $position->Title }}
                            </span>
                        </td>

                        <td>
                            <span class="record-description">
                                {{ $position->Description }}
                            </span>
                        </td>

                        <td>
                            <span class="count-badge">
                                {{ $position->employees->where('IsActive', true)->count() }}
                            </span>
                        </td>

                        <td class="table-actions">
                            <div class="actions">
                                <a
                                    href="/positions/details/{{ $position->Id }}"
                                    class="btn btn-primary btn-small"
                                >
                                    Details
                                </a>

                                <a
                                    href="/positions/edit/{{ $position->Id }}"
                                    class="btn btn-outline btn-small"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="/positions/delete/{{ $position->Id }}"
                                    class="inline-form"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-small"
                                        onclick="return confirm('Are you sure you want to deactivate this position?')"
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
            P
        </div>

        <h2>No positions found</h2>

        <p>
            No positions match the current search criteria.
        </p>

        <div class="page-actions">
            @if(!empty($search))
                <a
                    href="/positions"
                    class="btn btn-outline"
                >
                    Clear Search
                </a>
            @endif

            <a
                href="/positions/create"
                class="btn btn-primary"
            >
                Add New Position
            </a>
        </div>
    </div>
@endif

@endsection