<?php

namespace App\Services;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * ServiceCategoryService is responsible for handling business logic related to service categories.
 * It provides methods to retrieve, create, update, and deactivate service categories.
 */
class ServiceCategoryService
{
    /**
     * Retrieves all active service categories, optionally filtered by a search term.
     *
     * @param string|null $search The search term to filter service categories by title or description.
     * @return Collection A collection of active service categories.
     */
    public function getAll(?string $search = null): Collection
    {
        $query = ServiceCategory::where('IsActive', true);

        if ($search != null && $search != '') {
            $query->where(function ($q) use ($search) {
                $q->where('Title', 'like', '%' . $search . '%')
                    ->orWhere('Description', 'like', '%' . $search . '%');
            });
        }

        return $query->get();
    }

    /**
     * Retrieves a service category by its ID.
     *
     * @param int $id The ID of the service category to retrieve.
     * @return ServiceCategory The service category with the specified ID.
     */
    public function getById(int $id): ServiceCategory
    {
        return ServiceCategory::with(['serviceItems.serviceOrders'])->findOrFail($id);
    }

    /**
     * Adds a new service category to the database.
     *
     * @param Request $request The HTTP request containing the service category data.
     * @return void
     */
    public function addNew(Request $request): void
    {
        $request->validate([
            'Title' => ['required', 'min:2', 'max:64', Rule::unique('servicecategories', 'Title')],
            'Description' => ['required', 'min:5', 'max:1000'],
            'Notes' => ['nullable', 'max:1000'],
        ]);

        $userId = Auth::id();

        $category = new ServiceCategory();
        $category->Title = $request->input('Title');
        $category->Description = $request->input('Description');
        $category->Notes = $request->input('Notes');
        $category->IsActive = true;
        $category->CreationDateTime = now();
        $category->EditDateTime = now();
        $category->CreatedByUserId = $userId;
        $category->UpdatedByUserId = $userId;

        $category->save();
    }

    /**
     * Updates an existing service category in the database.
     *
     * @param Request $request The HTTP request containing the updated service category data.
     * @param int $id The ID of the service category to update.
     * @return void
     */
    public function update(Request $request, int $id): void
    {
        $request->validate([
            'Title' => [
                'required',
                'min:2',
                'max:64',
                Rule::unique('servicecategories', 'Title')->ignore($id, 'Id'),
            ],
            'Description' => ['required', 'min:5', 'max:1000'],
            'Notes' => ['nullable', 'max:1000'],
        ]);

        $userId = Auth::id();

        $category = ServiceCategory::findOrFail($id);
        $category->Title = $request->input('Title');
        $category->Description = $request->input('Description');
        $category->Notes = $request->input('Notes');
        $category->EditDateTime = now();
        $category->UpdatedByUserId = $userId;

        $category->save();
    }

    /**
     * Deactivates a service category by setting its IsActive flag to false.
     *
     * @param int $id The ID of the service category to deactivate.
     * @return void
     */
    public function deactivate(int $id): void
    {
        $category = ServiceCategory::findOrFail($id);
        $category->IsActive = false;
        $category->EditDateTime = now();
        $category->DeletedByUserId = Auth::id();
        $category->DeletedDateTime = now();

        $category->save();
    }
}