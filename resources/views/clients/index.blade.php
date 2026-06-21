@extends('main')

@section('title', 'Clients')

@section('content')

<section class="list-page-header">
    <div class="list-page-heading">
        <span class="section-label">
            Customer Management
        </span>

        <h1>Clients</h1>

        <p>
            Manage client records and review their contact and location details.
        </p>
    </div>

    <div class="list-page-actions">
        <a
            href="/clients/create"
            class="btn btn-primary"
        >
            Add New Client
        </a>
    </div>
</section>


<form
    method="GET"
    action="/clients"
    class="search-form"
>
    <div class="search-box search-box-simple">
        <div class="filter-field">
            <label for="client-search">
                Search clients
            </label>

            <input
                id="client-search"
                type="text"
                name="search"
                placeholder="Search by name, email, telephone or location..."
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
            href="/clients"
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
                    <th>Client</th>
                    <th>Date of Birth</th>
                    <th>Contact Details</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($models as $client)
                    <tr>
                        <td>
                            <div class="person-cell">
                                <span class="person-avatar">
                                    {{ strtoupper(substr($client->FirstName, 0, 1)) }}
                                    {{ strtoupper(substr($client->LastName, 0, 1)) }}
                                </span>

                                <div class="person-details">
                                    <span class="person-name">
                                        {{ $client->FirstName }}
                                        {{ $client->LastName }}
                                    </span>

                                    <span class="person-reference">
                                        Client ID: {{ $client->Id }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="date-value">
                                {{ $client->DateOfBirth }}
                            </span>
                        </td>

                        <td>
                            <div class="contact-list">
                                <a
                                    href="mailto:{{ $client->Email }}"
                                    class="contact-link"
                                >
                                    {{ $client->Email }}
                                </a>

                                <a
                                    href="tel:{{ $client->Phone }}"
                                    class="contact-link contact-secondary"
                                >
                                    {{ $client->Phone }}
                                </a>
                            </div>
                        </td>

                        <td>
                            <div class="location-cell">
                                <span class="location-city">
                                    {{ $client->City }}
                                </span>

                                <span class="location-postcode">
                                    {{ $client->PostCode }}
                                </span>
                            </div>
                        </td>

                        <td class="table-actions">
                            <div class="actions">
                                <a
                                    href="/clients/details/{{ $client->Id }}"
                                    class="btn btn-primary btn-small"
                                >
                                    Details
                                </a>

                                <a
                                    href="/clients/edit/{{ $client->Id }}"
                                    class="btn btn-outline btn-small"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="/clients/delete/{{ $client->Id }}"
                                    class="inline-form"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-small"
                                        onclick="return confirm('Are you sure you want to deactivate this client?')"
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
            X
        </div>

        <h2>No clients found</h2>

        <p>
            No clients match the current search criteria.
        </p>

        <div class="page-actions">
            @if(!empty($search))
                <a
                    href="/clients"
                    class="btn btn-outline"
                >
                    Clear Search
                </a>
            @endif

            <a
                href="/clients/create"
                class="btn btn-primary"
            >
                Add New Client
            </a>
        </div>
    </div>
@endif

@endsection