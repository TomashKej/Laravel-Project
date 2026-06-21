@extends('main')

@section('content')

@php
    $activeOrders = $model->serviceOrders->where('IsActive', true);

    $totalOrderValue = $activeOrders->sum(function ($order) {
        return $order->serviceItems->sum('Price');
    });
@endphp

<h1>Employee Details</h1>

<div class="details-card">
    <h2>{{ $model->FirstName }} {{ $model->LastName }}</h2>

    <div class="details-grid">
        <div>
            <strong>Email:</strong>
            <p>{{ $model->Email }}</p>
        </div>

        <div>
            <strong>Phone:</strong>
            <p>{{ $model->Phone }}</p>
        </div>

        <div>
            <strong>Position:</strong>
            <p>{{ $model->position->Title ?? $model->Position }}</p>
        </div>

        <div>
            <strong>Status:</strong>
            <p>{{ $model->IsActive ? 'Active' : 'Inactive' }}</p>
        </div>

        <div>
            <strong>Assigned Active Orders:</strong>
            <p>{{ $activeOrders->count() }}</p>
        </div>

        <div>
            <strong>Total Assigned Order Value:</strong>
            <p>£{{ number_format($totalOrderValue, 2) }}</p>
        </div>
    </div>

    <div class="summary-card">
        <h2>Total Assigned Order Value</h2>
        <p class="summary-value">
            £{{ number_format($totalOrderValue, 2) }}
        </p>
    </div>

    @if($model->Notes)
        <hr>

        <h3>Notes</h3>
        <p>{{ $model->Notes }}</p>
    @endif

    <hr>

    <h3>Assigned Service Orders</h3>

    @if($activeOrders->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Order Title</th>
                    <th>Client</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>Deadline</th>
                    <th>Total Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($activeOrders as $order)
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
        <p>This employee is not assigned to any active service order.</p>
    @endif

    <hr>

    <h3>Audit Information</h3>

    <div class="details-grid">
        <div>
            <strong>Created:</strong>
            <p>{{ $model->CreationDateTime }}</p>
        </div>

        <div>
            <strong>Last Updated:</strong>
            <p>{{ $model->EditDateTime }}</p>
        </div>

        <div>
            <strong>Created By User ID:</strong>
            <p>{{ $model->CreatedByUserId ?? 'Not available' }}</p>
        </div>

        <div>
            <strong>Updated By User ID:</strong>
            <p>{{ $model->UpdatedByUserId ?? 'Not available' }}</p>
        </div>
    </div>

    <div class="page-actions">
        <a href="/employees/edit/{{ $model->Id }}" class="btn btn-primary">Edit</a>
        <a href="/employees" class="btn btn-secondary">Back to List</a>
    </div>
</div>

@endsection