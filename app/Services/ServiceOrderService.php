<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Employee;
use App\Models\ServiceItem;
use App\Models\ServiceOrder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * The ServiceOrderService class provides methods for managing service orders, including retrieving, adding, updating, and deactivating service orders.
 * It also provides methods to retrieve active clients, employees, and service items.
 */
class ServiceOrderService
{
    /**
     * Retrieves all active service orders, optionally filtered by a search term.
     *
     * @param string|null $search The search term to filter service orders.
     * @return Collection The collection of active service orders.
     */
    public function getAll(?string $search = null): Collection
    {
        // Build the query to retrieve active service orders with related client, employees, and service items
        $query = ServiceOrder::with(['client', 'employees', 'serviceItems'])
            ->where('IsActive', true);

        // Apply search filters if a search term is provided
        if ($search != null && $search != '') {
            $query->where(function ($q) use ($search) {
                $q->where('Title', 'like', '%' . $search . '%')
                    ->orWhere('Status', 'like', '%' . $search . '%')
                    ->orWhere('Description', 'like', '%' . $search . '%')
                    ->orWhereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery->where('FirstName', 'like', '%' . $search . '%')
                            ->orWhere('LastName', 'like', '%' . $search . '%')
                            ->orWhere('Email', 'like', '%' . $search . '%');
                    })
                    // Search in related employees and service items
                    ->orWhereHas('employees', function ($employeeQuery) use ($search) {
                        $employeeQuery->where('FirstName', 'like', '%' . $search . '%')
                            ->orWhere('LastName', 'like', '%' . $search . '%')
                            ->orWhere('Position', 'like', '%' . $search . '%');
                    })
                    // Search in related service items
                    ->orWhereHas('serviceItems', function ($serviceItemQuery) use ($search) {
                        $serviceItemQuery->where('Title', 'like', '%' . $search . '%');
                    });
            });
        }

        return $query->get();
    }

    /**
     * Retrieves a service order by its ID, including related client, employees, and service items.
     *
     * @param int $id The ID of the service order.
     * @return ServiceOrder The service order instance.
     */
    public function getById(int $id): ServiceOrder
    {
        return ServiceOrder::with(['client', 'employees', 'serviceItems'])->findOrFail($id);
    }

    /**
     * Retrieves all active clients.
     *
     * @return Collection The collection of active clients.
     */
    public function getActiveClients(): Collection
    {
        return Client::where('IsActive', true)->get();
    }

    /**
     * Retrieves all active employees.
     *
     * @return Collection The collection of active employees.
     */
    public function getActiveEmployees(): Collection
    {
        return Employee::where('IsActive', true)->get();
    }

    /**
     * Retrieves all active service items.
     *
     * @return Collection The collection of active service items.
     */
    public function getActiveServiceItems(): Collection
    {
        return ServiceItem::where('IsActive', true)->get();
    }

    /**
     * Adds a new service order based on the provided request data.
     *
     * @param Request $request The request containing service order data.
     * @return void
     */
    public function addNew(Request $request): void
    {
        // Validate the request data
        $request->validate([
            'Title' => ['required', 'min:2', 'max:64'],
            'ClientId' => ['required', 'exists:clients,Id'],
            'Status' => ['required', Rule::in(['New', 'In Progress', 'Completed', 'Cancelled'])],
            'StartDateTime' => ['required', 'date'],
            'Deadline' => ['required', 'date', 'after_or_equal:StartDateTime'],
            'Description' => ['required', 'min:5', 'max:2000'],
            'Notes' => ['nullable', 'max:1000'],

            // Validate that at least one employee is selected and that each selected employee exists in the employees table
            'EmployeeIds' => ['required', 'array', 'min:1'],
            'EmployeeIds.*' => ['exists:employees,Id'],

            // Validate that at least one service item is selected and that each selected service item exists in the serviceitems table
            'ServiceItemIds' => ['required', 'array', 'min:1'],
            'ServiceItemIds.*' => ['exists:serviceitems,Id'],
        ]);

        $userId = Auth::id();

        $serviceOrder = new ServiceOrder();
        $serviceOrder->Title = $request->input('Title');
        $serviceOrder->ClientId = $request->input('ClientId');
        $serviceOrder->Status = $request->input('Status');
        $serviceOrder->StartDateTime = $request->input('StartDateTime');
        $serviceOrder->Deadline = $request->input('Deadline');
        $serviceOrder->Description = $request->input('Description');
        $serviceOrder->Notes = $request->input('Notes');
        $serviceOrder->IsActive = true;
        $serviceOrder->CreationDateTime = now();
        $serviceOrder->EditDateTime = now();
        $serviceOrder->CreatedByUserId = $userId;
        $serviceOrder->UpdatedByUserId = $userId;

        $serviceOrder->save();

        $serviceOrder->employees()->sync($request->input('EmployeeIds'));
        $serviceOrder->serviceItems()->sync($request->input('ServiceItemIds'));
    }

    /**
     * Updates an existing service order based on the provided request data and service order ID.
     *
     * @param Request $request The request containing updated service order data.
     * @param int $id The ID of the service order to update.
     * @return void
     */
    public function update(Request $request, int $id): void
    {
        $request->validate([
            'Title' => ['required', 'min:2', 'max:64'],
            'ClientId' => ['required', 'exists:clients,Id'],
            'Status' => ['required', Rule::in(['New', 'In Progress', 'Completed', 'Cancelled'])],
            'StartDateTime' => ['required', 'date'],
            'Deadline' => ['required', 'date', 'after_or_equal:StartDateTime'],
            'Description' => ['required', 'min:5', 'max:2000'],
            'Notes' => ['nullable', 'max:1000'],

            'EmployeeIds' => ['required', 'array', 'min:1'],
            'EmployeeIds.*' => ['exists:employees,Id'],

            'ServiceItemIds' => ['required', 'array', 'min:1'],
            'ServiceItemIds.*' => ['exists:serviceitems,Id'],
        ]);

        $userId = Auth::id();

        $serviceOrder = ServiceOrder::findOrFail($id);
        $serviceOrder->Title = $request->input('Title');
        $serviceOrder->ClientId = $request->input('ClientId');
        $serviceOrder->Status = $request->input('Status');
        $serviceOrder->StartDateTime = $request->input('StartDateTime');
        $serviceOrder->Deadline = $request->input('Deadline');
        $serviceOrder->Description = $request->input('Description');
        $serviceOrder->Notes = $request->input('Notes');
        $serviceOrder->EditDateTime = now();
        $serviceOrder->UpdatedByUserId = $userId;

        $serviceOrder->save();

        $serviceOrder->employees()->sync($request->input('EmployeeIds'));
        $serviceOrder->serviceItems()->sync($request->input('ServiceItemIds'));
    }

    /**
     * Deactivates a service order by its ID, marking it as inactive and recording the user who performed the action.
     *
     * @param int $id The ID of the service order to deactivate.
     * @return void
     */
    public function deactivate(int $id): void
    {
        $serviceOrder = ServiceOrder::findOrFail($id);
        $serviceOrder->IsActive = false;
        $serviceOrder->EditDateTime = now();
        $serviceOrder->DeletedByUserId = Auth::id();
        $serviceOrder->DeletedDateTime = now();

        $serviceOrder->save();
    }
}