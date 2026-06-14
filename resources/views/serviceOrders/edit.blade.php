@extends('main')

@section('content')

@php

    /*
        Prepare the selected employee and service item IDs for the edit form.
        If there are old input values (from a previous submission), use those.
        Otherwise, use the existing values from the model.
    */

    // Get the selected employee IDs from old input or from the model's employees relationship
    $selectedEmployeeIds = old('EmployeeIds', $model->employees->pluck('Id')->toArray());
    $selectedServiceItemIds = old('ServiceItemIds', $model->serviceItems->pluck('Id')->toArray());

    // Prepare the start date and deadline values for the edit form
    $startDateTime = old(
        'StartDateTime',
        $model->StartDateTime ? \Carbon\Carbon::parse($model->StartDateTime)->format('Y-m-d\TH:i') : ''
    );

    // Prepare the deadline value for the edit form
    $deadline = old(
        'Deadline',
        $model->Deadline ? \Carbon\Carbon::parse($model->Deadline)->format('Y-m-d\TH:i') : ''
    );
@endphp

<h1>Edit Service Order</h1>

<!-- This form allows users to edit an existing service order. It includes fields for title, client, status, start date and time, deadline, description, employees, service items, and notes. -->
<form method="POST" action="/serviceOrders/edit/{{ $model->Id }}">
    @csrf

    <label>Title</label>
    <input type="text" name="Title" value="{{ old('Title', $model->Title) }}">
    @error('Title')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Client</label>
    <select name="ClientId">
        <option value="">-- Select client --</option>

        @foreach($clients as $client)
            <option value="{{ $client->Id }}"
                {{ old('ClientId', $model->ClientId) == $client->Id ? 'selected' : '' }}>
                {{ $client->FirstName }} {{ $client->LastName }} - {{ $client->Email }}
            </option>
        @endforeach
    </select>
    @error('ClientId')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Status</label>
    <select name="Status">
        <option value="">-- Select status --</option>
        <option value="New" {{ old('Status', $model->Status) == 'New' ? 'selected' : '' }}>New</option>
        <option value="In Progress" {{ old('Status', $model->Status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
        <option value="Completed" {{ old('Status', $model->Status) == 'Completed' ? 'selected' : '' }}>Completed</option>
        <option value="Cancelled" {{ old('Status', $model->Status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
    @error('Status')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Start Date and Time</label>
    <input type="datetime-local" name="StartDateTime" value="{{ $startDateTime }}">
    @error('StartDateTime')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Deadline</label>
    <input type="datetime-local" name="Deadline" value="{{ $deadline }}">
    @error('Deadline')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Description</label>
    <textarea name="Description">{{ old('Description', $model->Description) }}</textarea>
    @error('Description')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Employees</label>
    <div class="checkbox-list">
        @foreach($employees as $employee)
            <label class="checkbox-item">
                <input type="checkbox"
                       name="EmployeeIds[]"
                       value="{{ $employee->Id }}"
                       {{ in_array($employee->Id, $selectedEmployeeIds) ? 'checked' : '' }}>
                {{ $employee->FirstName }} {{ $employee->LastName }} - {{ $employee->Position }}
            </label>
        @endforeach
    </div>
    @error('EmployeeIds')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Service Items</label>
    <div class="checkbox-list">
        @foreach($serviceItems as $serviceItem)
            <label class="checkbox-item">
                <input type="checkbox"
                       name="ServiceItemIds[]"
                       value="{{ $serviceItem->Id }}"
                       {{ in_array($serviceItem->Id, $selectedServiceItemIds) ? 'checked' : '' }}>
                {{ $serviceItem->Title }} - £{{ number_format($serviceItem->Price, 2) }}
            </label>
        @endforeach
    </div>
    @error('ServiceItemIds')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Notes</label>
    <textarea name="Notes">{{ old('Notes', $model->Notes) }}</textarea>
    @error('Notes')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="/serviceOrders" class="btn btn-secondary">Cancel</a>
</form>

@endsection