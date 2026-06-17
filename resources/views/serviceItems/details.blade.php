@extends('main')

@section('content')

@php
    $activeOrders = $model->serviceOrders->where('IsActive', true);
@endphp

<h1>Service Item Details</h1>

<div class="details-card">
    <h2>{{ $model->Title }}</h2>

    <div class="details-grid">
        <div>
            <strong>Category:</strong>
            <p>{{ $model->serviceCategory->Title ?? 'No category' }}</p>
        </div>

        <div>
            <strong>Price:</strong>
            <p>£{{ number_format($model->Price, 2) }}</p>
        </div>

        <div>
            <strong>Active Orders Using This Service:</strong>
            <p>{{ $activeOrders->count() }}</p>
        </div>

        <div>
            <strong>Status:</strong>
            <p>{{ $model->IsActive ? 'Active' : 'Inactive' }}</p>
        </div>
    </div>

    <div class="summary-card">
        <h2>Service Price</h2>
        <p class="summary-value">
            £{{ number_format($model->Price, 2) }}
        </p>
    </div>

    <hr>

    <h3>Description</h3>
    <p>{{ $model->Description }}</p>

    @if($model->Notes)
        <h3>Notes</h3>
        <p>{{ $model->Notes }}</p>
    @endif

    <hr>

    <h3>Related Service Orders</h3>

    @if($activeOrders->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Order Title</th>
                    <th>Client</th>
                    <th>Status</th>
                    <th>Deadline</th>
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
                        <td>{{ $order->Deadline }}</td>

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
        <p>This service item is not used in any active service order.</p>
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
        <a href="/serviceItems/edit/{{ $model->Id }}" class="btn btn-primary">Edit</a>
        <a href="/serviceItems" class="btn btn-secondary">Back to List</a>
    </div>
</div>

@endsection