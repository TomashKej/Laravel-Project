@extends('main')

@section('content')

<h1>Service Orders</h1>

<!-- This section displays a button to add a new service order and a search form for filtering service orders. -->
<div class="page-actions">
    <a href="/serviceOrders/create" class="btn btn-primary">Add Service Order</a>
</div>

<form method="GET" action="/serviceOrders" class="search-form">
    <div class="search-box">
        <input type="text" name="search" placeholder="Search service orders..." value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="/serviceOrders" class="btn btn-secondary">Clear</a>
    </div>
</form>

<!-- This section displays a table of service orders with their details and actions. -->
<table>
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