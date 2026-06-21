@extends('main')

@section('content')

@php
    $activeServiceItems = $model->serviceItems->where('IsActive', true);

    $relatedOrders = $activeServiceItems
        ->flatMap(function ($serviceItem) {
            return $serviceItem->serviceOrders;
        })
        ->where('IsActive', true)
        ->unique('Id');

    $totalServiceValue = $activeServiceItems->sum('Price');
@endphp

<h1>Service Category Details</h1>

<div class="details-card">
    <h2>{{ $model->Title }}</h2>

    <div class="details-grid">
        <div>
            <strong>Status:</strong>
            <p>{{ $model->IsActive ? 'Active' : 'Inactive' }}</p>
        </div>

        <div>
            <strong>Active Service Items:</strong>
            <p>{{ $activeServiceItems->count() }}</p>
        </div>

        <div>
            <strong>Related Active Orders:</strong>
            <p>{{ $relatedOrders->count() }}</p>
        </div>

        <div>
            <strong>Total Services Value:</strong>
            <p>£{{ number_format($totalServiceValue, 2) }}</p>
        </div>
    </div>

    <div class="summary-card">
        <h2>Total Services Value in This Category</h2>
        <p class="summary-value">
            £{{ number_format($totalServiceValue, 2) }}
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

    <h3>Service Items in This Category</h3>

    @if($activeServiceItems->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Service Item</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Used in Orders</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($activeServiceItems as $serviceItem)
                    <tr>
                        <td>{{ $serviceItem->Title }}</td>
                        <td>{{ $serviceItem->Description }}</td>
                        <td>£{{ number_format($serviceItem->Price, 2) }}</td>

                        <td>
                            {{ $serviceItem->serviceOrders->where('IsActive', true)->count() }}
                        </td>

                        <td>
                            <a href="/serviceItems/details/{{ $serviceItem->Id }}" class="btn btn-primary btn-small">
                                Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>This category has no active service items.</p>
    @endif

    <hr>

    <h3>Related Service Orders</h3>

    @if($relatedOrders->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Order Title</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($relatedOrders as $order)
                    <tr>
                        <td>{{ $order->Title }}</td>
                        <td>{{ $order->Status }}</td>
                        <td>{{ $order->StartDateTime }}</td>
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
        <p>No active service orders are related to this category.</p>
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
        <a href="/serviceCategories/edit/{{ $model->Id }}" class="btn btn-primary">Edit</a>
        <a href="/serviceCategories" class="btn btn-secondary">Back to List</a>
    </div>
</div>

@endsection