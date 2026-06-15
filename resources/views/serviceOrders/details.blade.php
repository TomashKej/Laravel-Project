@extends('main')

@section('content')

@php
    $totalCost = $model->serviceItems->sum('Price');
@endphp

<h1>Service Order Details</h1>

<div class="details-card">
    <h2>{{ $model->Title }}</h2>

    <div class="details-grid">
        <div>
            <strong>Status:</strong>
            <p>{{ $model->Status }}</p>
        </div>

        <div>
            <strong>Total Cost:</strong>
            <p>£{{ number_format($totalCost, 2) }}</p>
        </div>

        <div>
            <strong>Start Date:</strong>
            <p>{{ $model->StartDateTime }}</p>
        </div>

        <div>
            <strong>Deadline:</strong>
            <p>{{ $model->Deadline }}</p>
        </div>
    </div>

    <hr>

    <h3>Client</h3>

    <p>
        <strong>Name:</strong>
        {{ $model->client->FirstName ?? '' }} {{ $model->client->LastName ?? '' }}
    </p>

    <p>
        <strong>Email:</strong>
        {{ $model->client->Email ?? 'No email' }}
    </p>

    <p>
        <strong>Phone:</strong>
        {{ $model->client->Phone ?? 'No phone' }}
    </p>

    <p>
        <strong>Address:</strong>
        {{ $model->client->Address ?? '' }},
        {{ $model->client->City ?? '' }},
        {{ $model->client->PostCode ?? '' }}
    </p>

    <hr>

    <h3>Description</h3>
    <p>{{ $model->Description }}</p>

    @if($model->Notes)
        <h3>Notes</h3>
        <p>{{ $model->Notes }}</p>
    @endif

    <hr>

    <h3>Assigned Employees</h3>

    @foreach($model->employees as $employee)
        <span class="badge">
            {{ $employee->FirstName }} {{ $employee->LastName }} - {{ $employee->Position }}
        </span>
    @endforeach

    @if($model->employees->count() == 0)
        <p>No employees assigned.</p>
    @endif

    <hr>

    <h3>Selected Services</h3>

    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
        </thead>

        <tbody>
            @foreach($model->serviceItems as $serviceItem)
                <tr>
                    <td>{{ $serviceItem->Title }}</td>
                    <td>{{ $serviceItem->Description }}</td>
                    <td>£{{ number_format($serviceItem->Price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="total-cost">
        Total Cost: £{{ number_format($totalCost, 2) }}
    </h3>

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
        <a href="/serviceOrders/edit/{{ $model->Id }}" class="btn btn-primary">Edit</a>
        <a href="/serviceOrders" class="btn btn-secondary">Back to List</a>
    </div>
</div>

@endsection