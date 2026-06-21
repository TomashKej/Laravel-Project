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
            <a href="/forgotPassword" class="btn btn-secondary">Forgot Password</a>
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

    <h2>Today's Service Orders</h2>

    @if($todayOrders->count() > 0)
        <table>
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
                        <td>{{ $order->Title }}</td>
    
                        <td>
                            {{ $order->client->FirstName ?? '' }}
                            {{ $order->client->LastName ?? '' }}
                        </td>
    
                        <td>{{ $order->Status }}</td>
                        <td>{{ $order->StartDateTime }}</td>
                        <td>{{ $order->Deadline }}</td>
    
                        <td>
                            £{{ number_format($order->serviceItems->sum('Price'), 2) }}
                        </td>
    
                        <td>
                            <a href="/serviceOrders/details/{{ $order->Id }}" class="btn btn-primary btn-small">
                                Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No service orders scheduled for today.</p>
    @endif
    
    <h2>Upcoming Deadlines</h2>
    
    @if($upcomingDeadlineOrders->count() > 0)
        <table>
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
                        <td>{{ $order->Title }}</td>
    
                        <td>
                            {{ $order->client->FirstName ?? '' }}
                            {{ $order->client->LastName ?? '' }}
                        </td>
    
                        <td>{{ $order->Status }}</td>
                        <td>{{ $order->Deadline }}</td>
    
                        <td>
                            £{{ number_format($order->serviceItems->sum('Price'), 2) }}
                        </td>
    
                        <td>
                            <a href="/serviceOrders/details/{{ $order->Id }}" class="btn btn-primary btn-small">
                                Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No upcoming deadlines in the next 7 days.</p>
    @endif
    
    <h2>Overdue Service Orders</h2>
    
    @if($overdueOrders->count() > 0)
        <table>
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
                        <td>{{ $order->Title }}</td>
    
                        <td>
                            {{ $order->client->FirstName ?? '' }}
                            {{ $order->client->LastName ?? '' }}
                        </td>
    
                        <td>{{ $order->Status }}</td>
                        <td>{{ $order->Deadline }}</td>
    
                        <td>
                            £{{ number_format($order->serviceItems->sum('Price'), 2) }}
                        </td>
    
                        <td>
                            <a href="/serviceOrders/details/{{ $order->Id }}" class="btn btn-primary btn-small">
                                Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No overdue service orders.</p>
    @endif

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