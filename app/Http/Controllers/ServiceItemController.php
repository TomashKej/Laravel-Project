<?php

namespace App\Http\Controllers;

use App\Services\ServiceItemService;
use Illuminate\Http\Request;

/**
 * The ServiceItemController class handles HTTP requests related to service items.
 * It provides methods for listing, creating, editing, updating, and deleting service items.
 */
class ServiceItemController extends Controller
{
    private ServiceItemService $service;

    public function __construct()
    {
        $this->service = new ServiceItemService();
    }

    /**
     * Displays a list of service items, optionally filtered by a search term.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing query parameters.
     * @return \Illuminate\View\View The view displaying the list of service items.
     */
    public function Index(Request $request)
    {
        $search = $request->query('search');
        $serviceItems = $this->service->getAll($search);

        return view('serviceItems.index', [
            'models' => $serviceItems,
            'search' => $search,
        ]);
    }

    /**
     * Displays the form for creating a new service item.
     *
     * @return \Illuminate\View\View The view displaying the create service item form.
     */
    public function Create()
    {
        $categories = $this->service->getActiveCategories();

        return view('serviceItems.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Handles the submission of the create service item form.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing form data.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the service items list.
     */
    public function Store(Request $request)
    {
        $this->service->addNew($request);

        return redirect('/serviceItems')->with('success', 'Service item has been created successfully.');
    }

    /**
     * Displays the form for editing an existing service item.
     *
     * @param int $id The ID of the service item to edit.
     * @return \Illuminate\View\View The view displaying the edit service item form.
     */
    public function Edit(int $id)
    {
        $serviceItem = $this->service->getById($id);
        $categories = $this->service->getActiveCategories();

        return view('serviceItems.edit', [
            'model' => $serviceItem,
            'categories' => $categories,
        ]);
    }

    /**
     * Handles the submission of the edit service item form.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing form data.
     * @param int $id The ID of the service item to update.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the service items list.
     */
    public function Update(Request $request, int $id)
    {
        $this->service->update($request, $id);

        return redirect('/serviceItems')->with('success', 'Service item has been updated successfully.');
    }

    /**
     * Deactivates a service item by setting its IsActive flag to false.
     *
     * @param int $id The ID of the service item to deactivate.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the service items list.
     */
    public function Delete(int $id)
    {
        $this->service->deactivate($id);

        return redirect('/serviceItems')->with('success', 'Service item has been deactivated successfully.');
    }
}