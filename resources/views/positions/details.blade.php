@extends('main')

@section('content')

@php
    $activeEmployees = $model->employees->where('IsActive', true);
    $inactiveEmployees = $model->employees->where('IsActive', false);
@endphp

<h1>Position Details</h1>

<div class="details-card">
    <h2>{{ $model->Title }}</h2>

    <div class="details-grid">
        <div>
            <strong>Status:</strong>
            <p>{{ $model->IsActive ? 'Active' : 'Inactive' }}</p>
        </div>

        <div>
            <strong>Active Employees:</strong>
            <p>{{ $activeEmployees->count() }}</p>
        </div>

        <div>
            <strong>Inactive Employees:</strong>
            <p>{{ $inactiveEmployees->count() }}</p>
        </div>

        <div>
            <strong>Created:</strong>
            <p>{{ $model->CreationDateTime }}</p>
        </div>
    </div>

    <div class="summary-card">
        <h2>Employees in This Position</h2>
        <p class="summary-value">
            {{ $model->employees->count() }}
        </p>
    </div>

    <hr>

    <h3>Description</h3>

    @if($model->Description)
        <p>{{ $model->Description }}</p>
    @else
        <p>No description provided.</p>
    @endif

    <hr>

    <h3>Employees</h3>

    @if($model->employees->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($model->employees as $employee)
                    <tr>
                        <td>{{ $employee->FirstName }} {{ $employee->LastName }}</td>
                        <td>{{ $employee->Email }}</td>
                        <td>{{ $employee->Phone }}</td>

                        <td>
                            @if($employee->IsActive)
                                <span class="badge">Active</span>
                            @else
                                <span class="badge">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <a href="/employees/details/{{ $employee->Id }}" class="btn btn-primary btn-small">
                                Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No employees assigned to this position.</p>
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
    </div>

    <div class="page-actions">
        <a href="/positions/edit/{{ $model->Id }}" class="btn btn-primary">Edit</a>
        <a href="/positions" class="btn btn-secondary">Back to List</a>
    </div>
</div>

@endsection