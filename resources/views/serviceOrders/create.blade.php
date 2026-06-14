@extends('main')

@section('content')

<h1>Add Service Order</h1>

<!-- This form allows users to create a new service order. It includes fields for title, client, status, start date and time, deadline, description, employees, service items, and notes. -->
<form method="POST" action="/serviceOrders/create">
    @csrf

    <label>Title</label>
    <input type="text" name="Title" value="{{ old('Title') }}">
    @error('Title')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Client</label>
    <select name="ClientId">
        <option value="">-- Select client --</option>

        @foreach($clients as $client)
            <option value="{{ $client->Id }}" {{ old('ClientId') == $client->Id ? 'selected' : '' }}>
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
        <option value="New" {{ old('Status') == 'New' ? 'selected' : '' }}>New</option>
        <option value="In Progress" {{ old('Status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
        <option value="Completed" {{ old('Status') == 'Completed' ? 'selected' : '' }}>Completed</option>
        <option value="Cancelled" {{ old('Status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
    @error('Status')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Start Date and Time</label>
    <input type="datetime-local" name="StartDateTime" value="{{ old('StartDateTime') }}">
    @error('StartDateTime')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Deadline</label>
    <input type="datetime-local" name="Deadline" value="{{ old('Deadline') }}">
    @error('Deadline')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Description</label>
    <textarea name="Description">{{ old('Description') }}</textarea>
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
                       {{ in_array($employee->Id, old('EmployeeIds', [])) ? 'checked' : '' }}>
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
                       {{ in_array($serviceItem->Id, old('ServiceItemIds', [])) ? 'checked' : '' }}>
                {{ $serviceItem->Title }} - £{{ number_format($serviceItem->Price, 2) }}
            </label>
        @endforeach
    </div>
    @error('ServiceItemIds')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Notes</label>
    <textarea name="Notes">{{ old('Notes') }}</textarea>
    @error('Notes')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="/serviceOrders" class="btn btn-secondary">Cancel</a>
</form>

@endsection