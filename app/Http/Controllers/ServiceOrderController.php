<?php

namespace App\Http\Controllers;

use App\Services\ServiceOrderService;
use Illuminate\Http\Request;

/**
 * The ServiceOrderController class handles HTTP requests related to service orders, including listing, creating, editing, updating, and deleting service orders.
 * It utilizes the ServiceOrderService to perform business logic and data manipulation.
 */
class ServiceOrderController extends Controller
{
    private ServiceOrderService $service;

    public function __construct()
    {
        $this->service = new ServiceOrderService();
    }

    /**
     * Displays a list of service orders, optionally filtered by a search term.
     *
     * @param Request $request The HTTP request containing query parameters.
     * @return \Illuminate\View\View The view displaying the list of service orders.
     */
    public function Index(Request $request)
    {
        $search = $request->query('search');
        $serviceOrders = $this->service->getAll($search);

        return view('serviceOrders.index', [
            'models' => $serviceOrders,
            'search' => $search,
        ]);
    }

    /**
     * Displays the form for creating a new service order.
     *
     * @return \Illuminate\View\View The view displaying the create service order form.
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
     * Handles the submission of the create service order form and adds a new service order.
     *
     * @param Request $request The HTTP request containing form data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the service orders list after successful creation.
     */
    public function Store(Request $request)
    {
        $this->service->addNew($request);

        return redirect('/serviceOrders');
    }

    /**
     * Displays the form for editing an existing service order.
     *
     * @param int $id The ID of the service order to edit.
     * @return \Illuminate\View\View The view displaying the edit service order form.
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
     * Handles the submission of the edit service order form and updates the existing service order.
     *
     * @param Request $request The HTTP request containing form data.
     * @param int $id The ID of the service order to update.
     * @return \Illuminate\Http\RedirectResponse Redirects to the service orders list after successful update.
     */
    public function Update(Request $request, int $id)
    {
        $this->service->update($request, $id);

        return redirect('/serviceOrders');
    }

    /**
     * Deletes a service order by its ID.
     *
     * @param int $id The ID of the service order to delete.
     * @return \Illuminate\Http\RedirectResponse Redirects to the service orders list after successful deletion.
     */
    public function Delete(int $id)
    {
        $this->service->deactivate($id);

        return redirect('/serviceOrders');
    }
}