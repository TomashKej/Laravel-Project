@extends('main')

@section('content')

<h1>Service Orders</h1>

<!-- This section displays a button to add a new service order and a search form for filtering service orders. -->
<div class="page-actions">
    <a href="/serviceOrders/create" class="btn btn-primary">Add Service Order</a>
</div>

<form method="GET" action="/serviceOrders" class="search-form">
    <div class="search-box">
        <input type="text"
               name="search"
               placeholder="Search by title, client, employee or service..."
               value="{{ $search ?? '' }}">

        <select name="status">
            <option value="">All statuses</option>
            <option value="New" {{ ($status ?? '') == 'New' ? 'selected' : '' }}>New</option>
            <option value="In Progress" {{ ($status ?? '') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
            <option value="Completed" {{ ($status ?? '') == 'Completed' ? 'selected' : '' }}>Completed</option>
            <option value="Cancelled" {{ ($status ?? '') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <div class="filter-field">
            <label>From</label>
            <input type="date"
                   name="dateFrom"
                   value="{{ $dateFrom ?? '' }}">
        </div>

        <div class="filter-field">
            <label>To</label>
            <input type="date"
                   name="dateTo"
                   value="{{ $dateTo ?? '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Search</button>
        <a href="/serviceOrders" class="btn btn-secondary btn-clear">Clear</a>
    </div>
</form>

<!-- This section displays a table of service orders with their details and actions. -->
<table class="data-table service-orders-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Client</th>
            <th>Status</th>
            <th>Deadline</th>
            <th>Employees</th>
            <th>Services</th>
            <th>Total Cost</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($models as $order)
            <tr>
                <td>{{ $order->Title }}</td>

                <td>
                    {{ $order->client->FirstName ?? '' }}
                    {{ $order->client->LastName ?? '' }}
                </td>

                <td>{{ $order->Status }}</td>
                <td>{{ $order->Deadline }}</td>

                <td>
                    @foreach($order->employees as $employee)
                        <span class="badge">
                            {{ $employee->FirstName }} {{ $employee->LastName }}
                        </span>
                    @endforeach
                </td>

                <td>
                    @foreach($order->serviceItems as $serviceItem)
                        <span class="badge">
                            {{ $serviceItem->Title }}
                        </span>
                    @endforeach
                </td>

                <td>
                    £{{ number_format($order->serviceItems->sum('Price'), 2) }}
                </td>

                <td>
                    <div class="actions">

                        <a href="/serviceOrders/details/{{ $order->Id }}" class="btn btn-primary btn-small">
                            Details
                        </a>

                        <a href="/serviceOrders/edit/{{ $order->Id }}" class="btn btn-secondary btn-small">
                            Edit
                        </a>

                        <form method="POST" action="/serviceOrders/delete/{{ $order->Id }}" class="inline-form">
                            @csrf

                            <button type="submit"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Are you sure you want to deactivate this service order?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- This section displays pagination links for navigating through multiple pages of service orders. -->
@if($models->count() == 0)
    <p>No service orders found.</p>
@endif

@endsection