<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Service class for managing Employee entities.
 */
class EmployeeService
{
    /**
     * Get all active employees, optionally filtered by a search term.
     *
     * @param string|null $search
     * @return Collection
     */
    public function getAll(?string $search = null): Collection
    {
        $query = Employee::where('IsActive', true);

        if ($search != null && $search != '') {
            $query->where(function ($q) use ($search) {
                $q->where('FirstName', 'like', '%' . $search . '%')
                    ->orWhere('LastName', 'like', '%' . $search . '%')
                    ->orWhere('Email', 'like', '%' . $search . '%')
                    ->orWhere('Phone', 'like', '%' . $search . '%')
                    ->orWhere('Position', 'like', '%' . $search . '%');
            });
        }

        return $query->get();
    }

    /**
     * Get an employee by its ID.
     *
     * @param int $id
     * @return Employee
     */
    public function getById(int $id): Employee
    {
        return Employee::findOrFail($id);
    }

    /**
     * Add a new employee to the database.
     *
     * @param Request $request
     * @return void
     */
    public function addNew(Request $request): void
    {
        $request->validate([
            'FirstName' => ['required', 'min:2', 'max:64', "regex:/^[\pL\s'-]+$/u"],
            'LastName' => ['required', 'min:2', 'max:64', "regex:/^[\pL\s'-]+$/u"],
            'Email' => ['required', 'email', 'max:128', Rule::unique('employees', 'Email')],
            'Phone' => ['required', 'min:7', 'max:32'],
            'Position' => ['required', 'min:2', 'max:64'],
            'Notes' => ['nullable', 'max:1000'],
        ]);

        $userId = Auth::id();

        $employee = new Employee();
        $employee->FirstName = $request->input('FirstName');
        $employee->LastName = $request->input('LastName');
        $employee->Email = $request->input('Email');
        $employee->Phone = $request->input('Phone');
        $employee->Position = $request->input('Position');
        $employee->Notes = $request->input('Notes');
        $employee->IsActive = true;
        $employee->CreationDateTime = now();
        $employee->EditDateTime = now();
        $employee->CreatedByUserId = $userId;
        $employee->UpdatedByUserId = $userId;

        $employee->save();
    }

    /**
     * Update the specified employee in storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id): void
    {
        $request->validate([
            'FirstName' => ['required', 'min:2', 'max:64', "regex:/^[\pL\s'-]+$/u"],
            'LastName' => ['required', 'min:2', 'max:64', "regex:/^[\pL\s'-]+$/u"],
            'Email' => [
                'required',
                'email',
                'max:128',
                Rule::unique('employees', 'Email')->ignore($id, 'Id'),
            ],
            'Phone' => ['required', 'min:7', 'max:32'],
            'Position' => ['required', 'min:2', 'max:64'],
            'Notes' => ['nullable', 'max:1000'],
        ]);

        $userId = Auth::id();

        $employee = Employee::findOrFail($id);
        $employee->FirstName = $request->input('FirstName');
        $employee->LastName = $request->input('LastName');
        $employee->Email = $request->input('Email');
        $employee->Phone = $request->input('Phone');
        $employee->Position = $request->input('Position');
        $employee->Notes = $request->input('Notes');
        $employee->EditDateTime = now();
        $employee->UpdatedByUserId = $userId;

        $employee->save();
    }

    /**
     * Deactivate the specified employee in storage.
     *
     * @param int $id
     * @return void
     */
    public function deactivate(int $id): void
    {
        $employee = Employee::findOrFail($id);
        $employee->IsActive = false;
        $employee->EditDateTime = now();
        $employee->DeletedByUserId = Auth::id();
        $employee->DeletedDateTime = now();

        $employee->save();
    }
}