<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private EmployeeService $EmployeeService;

    public function __construct()
    {
        $this->EmployeeService = new EmployeeService();
    }

    /**
     * Display a listing of the employees.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function Index(Request $request)
    {
        $search = $request->query('search');
        $employees = $this->EmployeeService->getAll($search);

        return view('employees.index', [
            'models' => $employees,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\View\View
     */
    public function Create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function Store(Request $request)
    {
        $this->EmployeeService->addNew($request);

        return redirect('/employees')->with('success', 'Employee has been created successfully.');
    }

    /**
     * Show the form for editing the specified employee.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function Edit(int $id)
    {
        $employee = $this->EmployeeService->getById($id);

        return view('employees.edit', [
            'model' => $employee,
        ]);
    }

    /**
     * Update the specified employee in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function Update(Request $request, int $id)
    {
        $this->EmployeeService->update($request, $id);

        return redirect('/employees')->with('success', 'Employee has been updated successfully.');
    }

    /**
     * Deactivate the specified employee in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function Delete(int $id)
    {
        $this->EmployeeService->deactivate($id);

        return redirect('/employees')->with('success', 'Employee has been deactivated successfully.');
    }
}