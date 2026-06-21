<?php

namespace App\Http\Controllers;

use App\Services\ServiceOrderService;
use Illuminate\Http\Request;

/**
 * The ServiceOrderController class handles HTTP requests related to service orders,
 * including listing, creating, editing, updating, viewing details and deleting service orders.
 */
class ServiceOrderController extends Controller
{
    private ServiceOrderService $service;

    public function __construct()
    {
        $this->service = new ServiceOrderService();
    }

    /**
     * Displays a list of service orders, optionally filtered by search term, status and date range.
     */
    public function Index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $dateFrom = $request->query('dateFrom');
        $dateTo = $request->query('dateTo');

        $serviceOrders = $this->service->getAll($search, $status, $dateFrom, $dateTo);

        return view('serviceOrders.index', [
            'models' => $serviceOrders,
            'search' => $search,
            'status' => $status,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    /**
     * Displays the form for creating a new service order.
     */
    public function Create()
    {
        return view('serviceOrders.create', [
            'clients' => $this->service->getActiveClients(),
            'employees' => $this->service->getActiveEmployees(),
            'serviceItems' => $this->service->getActiveServiceItems(),
        ]);
    }

    /**
     * Handles the submission of the create service order form.
     */
    public function Store(Request $request)
    {
        $this->service->addNew($request);

        return redirect('/serviceOrders')->with('success', 'Service order has been created successfully.');
    }

    /**
     * Displays the form for editing an existing service order.
     */
    public function Edit(int $id)
    {
        $serviceOrder = $this->service->getById($id);

        return view('serviceOrders.edit', [
            'model' => $serviceOrder,
            'clients' => $this->service->getActiveClients(),
            'employees' => $this->service->getActiveEmployees(),
            'serviceItems' => $this->service->getActiveServiceItems(),
        ]);
    }

    /**
     * Displays service order details.
     */
    public function Details(int $id)
    {
        $serviceOrder = $this->service->getById($id);

        return view('serviceOrders.details', [
            'model' => $serviceOrder,
        ]);
    }

    /**
     * Handles the submission of the edit service order form.
     */
    public function Update(Request $request, int $id)
    {
        $this->service->update($request, $id);

        return redirect('/serviceOrders')->with('success', 'Service order has been updated successfully.');
    }

    /**
     * Deactivates a service order by its ID.
     */
    public function Delete(int $id)
    {
        $this->service->deactivate($id);

        return redirect('/serviceOrders')->with('success', 'Service order has been deactivated successfully.');
    }
}