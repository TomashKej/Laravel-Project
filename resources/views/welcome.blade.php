@extends('main')

@section('content')

<h1>Welcome</h1>

@guest
    <div class="welcome-box">
        <h2>Service Order Management System</h2>

        <p>
            This application helps manage clients, employees, service categories,
            service items and service orders in a simple Laravel MVC system.
        </p>

        <div class="page-actions">
            <a href="/login" class="btn btn-primary">Login</a>
            <a href="/register" class="btn btn-secondary">Register</a>
        </div>
    </div>
@endguest

@auth
    <div class="welcome-box">
        <h2>Business Dashboard</h2>

        <p>
            Overview of active records and current service order value.
        </p>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h3>Clients</h3>
            <p>{{ $activeClientsCount }}</p>
        </div>

        <div class="dashboard-card">
            <h3>Employees</h3>
            <p>{{ $activeEmployeesCount }}</p>
        </div>

        <div class="dashboard-card">
            <h3>Service Items</h3>
            <p>{{ $activeServiceItemsCount }}</p>
        </div>

        <div class="dashboard-card">
            <h3>Service Orders</h3>
            <p>{{ $activeServiceOrdersCount }}</p>
        </div>
    </div>

    <div class="summary-card">
        <h2>Total Active Order Value</h2>
        <p class="summary-value">
            £{{ number_format($totalOrderValue, 2) }}
        </p>
    </div>

    <h2>Orders by Status</h2>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h3>New</h3>
            <p>{{ $newOrdersCount }}</p>
        </div>

        <div class="dashboard-card">
            <h3>In Progress</h3>
            <p>{{ $inProgressOrdersCount }}</p>
        </div>

        <div class="dashboard-card">
            <h3>Completed</h3>
            <p>{{ $completedOrdersCount }}</p>
        </div>

        <div class="dashboard-card">
            <h3>Cancelled</h3>
            <p>{{ $cancelledOrdersCount }}</p>
        </div>
    </div>

    <div class="page-actions">
        <a href="/serviceOrders" class="btn btn-primary">View Service Orders</a>
        <a href="/clients" class="btn btn-secondary">View Clients</a>
    </div>
@endauth

@endsection