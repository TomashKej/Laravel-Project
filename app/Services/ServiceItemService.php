<?php

namespace App\Services;

use App\Models\ServiceCategory;
use App\Models\ServiceItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * The ServiceItemService class provides methods to manage service items in the application.
 * It includes functionalities for retrieving, adding, updating, and deactivating service items.
 */
class ServiceItemService
{
    /**
     * Retrieves all active service items, optionally filtered by a search term.
     *
     * @param string|null $search The search term to filter service items.
     * @return \Illuminate\Database\Eloquent\Collection A collection of active service items.
     */
    public function getAll(?string $search = null): Collection
    {
        $query = ServiceItem::with('serviceCategory')
            ->where('IsActive', true);

        if ($search != null && $search != '') {
            $query->where(function ($q) use ($search) {
                $q->where('Title', 'like', '%' . $search . '%')
                    ->orWhere('Description', 'like', '%' . $search . '%')
                    ->orWhere('Price', 'like', '%' . $search . '%')
                    ->orWhereHas('serviceCategory', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('Title', 'like', '%' . $search . '%');
                    });
            });
        }

        return $query->get();
    }

    /**
     * Retrieves a service item by its ID.
     *
     * @param int $id The ID of the service item to retrieve.
     * @return \App\Models\ServiceItem The service item with the specified ID.
     */
    public function getById(int $id): ServiceItem
    {
        return ServiceItem::findOrFail($id);
    }

    /**
     * Retrieves all active service categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of active service categories.
     */
    public function getActiveCategories(): Collection
    {
        return ServiceCategory::where('IsActive', true)->get();
    }

    /**
     * Adds a new service item to the database.
     *
     * @param \Illuminate\Http\Request $request The request containing the service item data.
     * @return void
     */
    public function addNew(Request $request): void
    {
        $request->validate([
            'Title' => ['required', 'min:2', 'max:64', Rule::unique('serviceitems', 'Title')],
            'Description' => ['required', 'min:5', 'max:1000'],
            'Price' => ['required', 'numeric', 'min:0'],
            'ServiceCategoryId' => ['required', 'exists:servicecategories,Id'],
            'Notes' => ['nullable', 'max:1000'],
        ]);

        $userId = Auth::id();

        $serviceItem = new ServiceItem();
        $serviceItem->Title = $request->input('Title');
        $serviceItem->Description = $request->input('Description');
        $serviceItem->Price = $request->input('Price');
        $serviceItem->ServiceCategoryId = $request->input('ServiceCategoryId');
        $serviceItem->Notes = $request->input('Notes');
        $serviceItem->IsActive = true;
        $serviceItem->CreationDateTime = now();
        $serviceItem->EditDateTime = now();
        $serviceItem->CreatedByUserId = $userId;
        $serviceItem->UpdatedByUserId = $userId;

        $serviceItem->save();
    }

    /**
     * Updates an existing service item in the database.
     *
     * @param \Illuminate\Http\Request $request The request containing the updated service item data.
     * @param int $id The ID of the service item to update.
     * @return void
     */
    public function update(Request $request, int $id): void
    {
        $request->validate([
            'Title' => [
                'required',
                'min:2',
                'max:64',
                Rule::unique('serviceitems', 'Title')->ignore($id, 'Id'),
            ],
            'Description' => ['required', 'min:5', 'max:1000'],
            'Price' => ['required', 'numeric', 'min:0'],
            'ServiceCategoryId' => ['required', 'exists:servicecategories,Id'],
            'Notes' => ['nullable', 'max:1000'],
        ]);

        $userId = Auth::id();

        $serviceItem = ServiceItem::findOrFail($id);
        $serviceItem->Title = $request->input('Title');
        $serviceItem->Description = $request->input('Description');
        $serviceItem->Price = $request->input('Price');
        $serviceItem->ServiceCategoryId = $request->input('ServiceCategoryId');
        $serviceItem->Notes = $request->input('Notes');
        $serviceItem->EditDateTime = now();
        $serviceItem->UpdatedByUserId = $userId;

        $serviceItem->save();
    }

    /**
     * Deactivates a service item by setting its IsActive flag to false.
     *
     * @param int $id The ID of the service item to deactivate.
     * @return void
     */
    public function deactivate(int $id): void
    {
        $serviceItem = ServiceItem::findOrFail($id);
        $serviceItem->IsActive = false;
        $serviceItem->EditDateTime = now();
        $serviceItem->DeletedByUserId = Auth::id();
        $serviceItem->DeletedDateTime = now();

        $serviceItem->save();
    }
}