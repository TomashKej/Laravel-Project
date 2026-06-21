<?php

namespace App\Http\Controllers;

use App\Services\ServiceCategoryService;
use Illuminate\Http\Request;

/**
 * ServiceCategoryController handles HTTP requests related to service categories.
 * It utilizes the ServiceCategoryService to perform business logic operations.
 */
class ServiceCategoryController extends Controller
{
    private ServiceCategoryService $service;

    public function __construct()
    {
        $this->service = new ServiceCategoryService();
    }

    /**
     * Display a listing of the service categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function Index(Request $request)
    {
        $search = $request->query('search');
        $categories = $this->service->getAll($search);

        return view('serviceCategories.index', [
            'models' => $categories,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new service category.
     *
     * @return \Illuminate\Http\Response
     */
    public function Create()
    {
        return view('serviceCategories.create');
    }

    /**
     * Store a newly created service category in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function Store(Request $request)
    {
        $this->service->addNew($request);

        return redirect('/serviceCategories')->with('success', 'Service category has been created successfully.');
    }

    /**
     * Show the form for editing the specified service category.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function Edit(int $id)
    {
        $category = $this->service->getById($id);

        return view('serviceCategories.edit', [
            'model' => $category,
        ]);
    }


    public function Details(int $id)
    {
        $serviceCategory = $this->service->getById($id);

        return view('serviceCategories.details', [
            'model' => $serviceCategory
        ]);
    }

    /**
     * Update the specified service category in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function Update(Request $request, int $id)
    {
        $this->service->update($request, $id);

        return redirect('/serviceCategories')->with('success', 'Service category has been updated successfully.');
    }

    /**
     * Remove the specified service category from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function Delete(int $id)
    {
        $this->service->deactivate($id);

        return redirect('/serviceCategories')->with('success', 'Service category has been deactivated successfully.');
    }
}