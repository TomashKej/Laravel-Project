@extends('main')

@section('title', 'Dashboard')

@section('content')

@guest
    <section class="welcome-hero">
        <div class="welcome-hero-content">
            <span class="section-label">
                Service Management
            </span>

            <h1>
                Manage your service orders in one place
            </h1>

            <p class="welcome-description">
                A business management system for handling clients, employees,
                service categories, service items and customer service orders.
            </p>

            <div class="page-actions">
                <a href="/login" class="btn btn-primary">
                    Login to System
                </a>

                <a href="/forgotPassword" class="btn btn-outline">
                    Forgot Password
                </a>
            </div>
        </div>

        <div class="welcome-information-card">
            <div class="information-icon">
                SO
            </div>

            <h2>Service Order System</h2>

            <p>
                Keep business information organised and quickly access
                the records required for everyday work.
            </p>

            <div class="information-list">
                <div class="information-list-item">
                    <span>✓</span>
                    Client and employee management
                </div>

                <div class="information-list-item">
                    <span>✓</span>
                    Service catalogue management
                </div>

                <div class="information-list-item">
                    <span>✓</span>
                    Order status and deadline tracking
                </div>
            </div>
        </div>
    </section>
@endguest


@auth
    <section class="dashboard-header">
        <div>
            <span class="section-label">
                Business overview
            </span>

            <h1>Dashboard</h1>

            <p>
                Review active business records, service orders and upcoming deadlines.
            </p>
        </div>

        <div class="dashboard-header-actions">
            <a href="/serviceOrders" class="btn btn-primary">
                View Service Orders
            </a>
        </div>
    </section>


    <section class="dashboard-grid">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <span class="dashboard-card-label">
                    Clients
                </span>

                <span class="dashboard-card-icon">
                    C
                </span>
            </div>

            <p class="dashboard-card-value">
                {{ $activeClientsCount }}
            </p>

            <a href="/clients" class="dashboard-card-link">
                View clients
            </a>
        </div>


        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <span class="dashboard-card-label">
                    Employees
                </span>

                <span class="dashboard-card-icon">
                    E
                </span>
            </div>

            <p class="dashboard-card-value">
                {{ $activeEmployeesCount }}
            </p>

            <a href="/employees" class="dashboard-card-link">
                View employees
            </a>
        </div>


        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <span class="dashboard-card-label">
                    Service Items
                </span>

                <span class="dashboard-card-icon">
                    S
                </span>
            </div>

            <p class="dashboard-card-value">
                {{ $activeServiceItemsCount }}
            </p>

            <a href="/serviceItems" class="dashboard-card-link">
                View services
            </a>
        </div>


        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <span class="dashboard-card-label">
                    Service Orders
                </span>

                <span class="dashboard-card-icon">
                    O
                </span>
            </div>

            <p class="dashboard-card-value">
                {{ $activeServiceOrdersCount }}
            </p>

            <a href="/serviceOrders" class="dashboard-card-link">
                View orders
            </a>
        </div>
    </section>


    <section class="summary-card">
        <div>
            <span class="summary-label">
                Current business value
            </span>

            <h2>Total Active Order Value</h2>

            <p>
                Combined value of services assigned to all active service orders.
            </p>
        </div>

        <div class="summary-value">
            £{{ number_format($totalOrderValue, 2) }}
        </div>
    </section>


    <section class="dashboard-section">
        <div class="section-heading">
            <div>
                <span class="section-label">
                    Schedule
                </span>

                <h2>Today's Service Orders</h2>

                <p>
                    Orders scheduled to begin today.
                </p>
            </div>
        </div>

        @if($todayOrders->count() > 0)
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>Deadline</th>
                            <th>Total Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($todayOrders as $order)
                            <tr>
                                <td>
                                    <strong>
                                        {{ $order->Title }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $order->client->FirstName ?? '' }}
                                    {{ $order->client->LastName ?? '' }}
                                </td>

                                <td>
                                    <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $order->Status)) }}">
                                        {{ $order->Status }}
                                    </span>
                                </td>

                                <td>
                                    {{ $order->StartDateTime }}
                                </td>

                                <td>
                                    {{ $order->Deadline }}
                                </td>

                                <td class="table-price">
                                    £{{ number_format($order->serviceItems->sum('Price'), 2) }}
                                </td>

                                <td>
                                    <a
                                        href="/serviceOrders/details/{{ $order->Id }}"
                                        class="btn btn-primary btn-small"
                                    >
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    ✓
                </div>

                <h3>No orders scheduled for today</h3>

                <p>
                    There are currently no service orders beginning today.
                </p>
            </div>
        @endif
    </section>


    <section class="dashboard-section">
        <div class="section-heading">
            <div>
                <span class="section-label">
                    Next 7 days
                </span>

                <h2>Upcoming Deadlines</h2>

                <p>
                    Service orders with deadlines approaching soon.
                </p>
            </div>
        </div>

        @if($upcomingDeadlineOrders->count() > 0)
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Deadline</th>
                            <th>Total Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($upcomingDeadlineOrders as $order)
                            <tr>
                                <td>
                                    <strong>
                                        {{ $order->Title }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $order->client->FirstName ?? '' }}
                                    {{ $order->client->LastName ?? '' }}
                                </td>

                                <td>
                                    <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $order->Status)) }}">
                                        {{ $order->Status }}
                                    </span>
                                </td>

                                <td>
                                    {{ $order->Deadline }}
                                </td>

                                <td class="table-price">
                                    £{{ number_format($order->serviceItems->sum('Price'), 2) }}
                                </td>

                                <td>
                                    <a
                                        href="/serviceOrders/details/{{ $order->Id }}"
                                        class="btn btn-primary btn-small"
                                    >
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    ✓
                </div>

                <h3>No upcoming deadlines</h3>

                <p>
                    There are no service order deadlines within the next seven days.
                </p>
            </div>
        @endif
    </section>


    <section class="dashboard-section">
        <div class="section-heading">
            <div>
                <span class="section-label section-label-danger">
                    Attention required
                </span>

                <h2>Overdue Service Orders</h2>

                <p>
                    Orders which have passed their assigned deadline.
                </p>
            </div>
        </div>

        @if($overdueOrders->count() > 0)
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Deadline</th>
                            <th>Total Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($overdueOrders as $order)
                            <tr>
                                <td>
                                    <strong>
                                        {{ $order->Title }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $order->client->FirstName ?? '' }}
                                    {{ $order->client->LastName ?? '' }}
                                </td>

                                <td>
                                    <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $order->Status)) }}">
                                        {{ $order->Status }}
                                    </span>
                                </td>

                                <td class="deadline-overdue">
                                    {{ $order->Deadline }}
                                </td>

                                <td class="table-price">
                                    £{{ number_format($order->serviceItems->sum('Price'), 2) }}
                                </td>

                                <td>
                                    <a
                                        href="/serviceOrders/details/{{ $order->Id }}"
                                        class="btn btn-primary btn-small"
                                    >
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    ✓
                </div>

                <h3>No overdue service orders</h3>

                <p>
                    All current service order deadlines are under control.
                </p>
            </div>
        @endif
    </section>


    <section class="dashboard-section">
        <div class="section-heading">
            <div>
                <span class="section-label">
                    Order progress
                </span>

                <h2>Orders by Status</h2>

                <p>
                    Current distribution of active service orders.
                </p>
            </div>
        </div>

        <div class="status-grid">
            <div class="status-summary-card status-summary-new">
                <span>New</span>

                <strong>
                    {{ $newOrdersCount }}
                </strong>
            </div>

            <div class="status-summary-card status-summary-progress">
                <span>In Progress</span>

                <strong>
                    {{ $inProgressOrdersCount }}
                </strong>
            </div>

            <div class="status-summary-card status-summary-completed">
                <span>Completed</span>

                <strong>
                    {{ $completedOrdersCount }}
                </strong>
            </div>

            <div class="status-summary-card status-summary-cancelled">
                <span>Cancelled</span>

                <strong>
                    {{ $cancelledOrdersCount }}
                </strong>
            </div>
        </div>
    </section>


    <div class="page-actions page-actions-bottom">
        <a href="/serviceOrders" class="btn btn-primary">
            View Service Orders
        </a>

        <a href="/clients" class="btn btn-outline">
            View Clients
        </a>
    </div>
@endauth

@endsection