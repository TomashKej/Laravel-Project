@extends('main')

@section('title', 'Service Orders')

@section('content')

<section class="list-page-header">
    <div class="list-page-heading">
        <span class="section-label">
            Order Management
        </span>

        <h1>Service Orders</h1>

        <p>
            Manage customer service orders, assigned employees,
            selected services, deadlines and order statuses.
        </p>
    </div>

    <div class="list-page-actions">
        <a
            href="/serviceOrders/create"
            class="btn btn-primary"
        >
            Add New Service Order
        </a>
    </div>
</section>


<form
    method="GET"
    action="/serviceOrders"
    class="search-form"
>
    <div class="search-box">
        <div class="filter-field">
            <label for="service-order-search">
                Search orders
            </label>

            <input
                id="service-order-search"
                type="text"
                name="search"
                placeholder="Search by title, client, employee or service..."
                value="{{ $search ?? '' }}"
            >
        </div>


        <div class="filter-field">
            <label for="order-status">
                Status
            </label>

            <select
                id="order-status"
                name="status"
            >
                <option value="">
                    All statuses
                </option>

                <option
                    value="New"
                    {{ ($status ?? '') == 'New' ? 'selected' : '' }}
                >
                    New
                </option>

                <option
                    value="In Progress"
                    {{ ($status ?? '') == 'In Progress' ? 'selected' : '' }}
                >
                    In Progress
                </option>

                <option
                    value="Completed"
                    {{ ($status ?? '') == 'Completed' ? 'selected' : '' }}
                >
                    Completed
                </option>

                <option
                    value="Cancelled"
                    {{ ($status ?? '') == 'Cancelled' ? 'selected' : '' }}
                >
                    Cancelled
                </option>
            </select>
        </div>


        <div class="filter-field">
            <label for="date-from">
                From
            </label>

            <input
                id="date-from"
                type="date"
                name="dateFrom"
                value="{{ $dateFrom ?? '' }}"
            >
        </div>


        <div class="filter-field">
            <label for="date-to">
                To
            </label>

            <input
                id="date-to"
                type="date"
                name="dateTo"
                value="{{ $dateTo ?? '' }}"
            >
        </div>


        <button
            type="submit"
            class="btn btn-primary"
        >
            Search
        </button>

        <a
            href="/serviceOrders"
            class="btn btn-clear"
        >
            Clear
        </a>
    </div>
</form>


@if($models->count() > 0)
    <div class="table-container">
        <table class="data-table service-orders-list-table">
            <thead>
                <tr>
                    <th>Order</th>
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
                        <td>
                            <div class="order-title-cell">
                                <span class="record-title">
                                    {{ $order->Title }}
                                </span>

                                <span class="order-reference">
                                    Order ID: {{ $order->Id }}
                                </span>
                            </div>
                        </td>


                        <td>
                            <div class="order-client">
                                @if($order->client)
                                    <span class="order-client-name">
                                        {{ $order->client->FirstName }}
                                        {{ $order->client->LastName }}
                                    </span>

                                    <span class="order-reference">
                                        Client ID: {{ $order->client->Id }}
                                    </span>
                                @else
                                    <span class="order-client-empty">
                                        No client assigned
                                    </span>
                                @endif
                            </div>
                        </td>


                        <td>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $order->Status)) }}">
                                {{ $order->Status }}
                            </span>
                        </td>


                        <td>
                            <span class="order-deadline">
                                {{ $order->Deadline }}
                            </span>
                        </td>


                        <td>
                            <div class="assignment-list">
                                @forelse($order->employees as $employee)
                                    <span class="employee-badge">
                                        {{ $employee->FirstName }}
                                        {{ $employee->LastName }}
                                    </span>
                                @empty
                                    <span class="assignment-empty">
                                        No employees assigned
                                    </span>
                                @endforelse
                            </div>
                        </td>


                        <td>
                            <div class="assignment-list">
                                @forelse($order->serviceItems as $serviceItem)
                                    <span class="service-badge">
                                        {{ $serviceItem->Title }}
                                    </span>
                                @empty
                                    <span class="assignment-empty">
                                        No services assigned
                                    </span>
                                @endforelse
                            </div>
                        </td>


                        <td>
                            <span class="order-total">
                                £{{ number_format($order->serviceItems->sum('Price'), 2) }}
                            </span>
                        </td>


                        <td class="table-actions">
                            <div class="actions">
                                <a
                                    href="/serviceOrders/details/{{ $order->Id }}"
                                    class="btn btn-primary btn-small"
                                >
                                    Details
                                </a>

                                <a
                                    href="/serviceOrders/edit/{{ $order->Id }}"
                                    class="btn btn-outline btn-small"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="/serviceOrders/delete/{{ $order->Id }}"
                                    class="inline-form"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-small"
                                        onclick="return confirm('Are you sure you want to deactivate this service order?')"
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
            O
        </div>

        <h2>No service orders found</h2>

        <p>
            No service orders match the current search criteria.
        </p>

        <div class="page-actions">
            @if(
                !empty($search) ||
                !empty($status) ||
                !empty($dateFrom) ||
                !empty($dateTo)
            )
                <a
                    href="/serviceOrders"
                    class="btn btn-outline"
                >
                    Clear Filters
                </a>
            @endif

            <a
                href="/serviceOrders/create"
                class="btn btn-primary"
            >
                Add New Service Order
            </a>
        </div>
    </div>
@endif

@endsection