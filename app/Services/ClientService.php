<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

/**
 * Service class for managing clients.
 */
class ClientService
{
    /**
     * Get all active clients, optionally filtered by a search term.
     *
     * @param string|null $search
     * @return Collection
     */
    public function getAll(?string $search = null): Collection
    {
        $query = Client::where('IsActive', true);

        if ($search != null && $search != '') {
            $query->where(function ($q) use ($search) {
                $q->where('FirstName', 'like', '%' . $search . '%')
                    ->orWhere('LastName', 'like', '%' . $search . '%')
                    ->orWhere('Email', 'like', '%' . $search . '%')
                    ->orWhere('Phone', 'like', '%' . $search . '%')
                    ->orWhere('City', 'like', '%' . $search . '%')
                    ->orWhere('PostCode', 'like', '%' . $search . '%')
                    ->orWhere('Address', 'like', '%' . $search . '%')
                    ->orWhere('DateOfBirth', 'like', '%' . $search . '%');
            });
        }

        return $query->get();
    }

    /**
     * Get a client by its ID.
     *
     * @param int $id
     * @return Client
     */
    public function getById(int $id): Client
    {
        return Client::findOrFail($id);
    }

    /**
     * Add a new client to the database.
     *
     * @param Request $request
     * @return void
     */
    public function addNew(Request $request): void
    {
        $request->validate([
            'FirstName' => ['required', 'min:2', 'max:64', "regex:/^[\pL\s'-]+$/u"],
            'LastName' => ['required', 'min:2', 'max:64', "regex:/^[\pL\s'-]+$/u"],
            'DateOfBirth' => ['required', 'date', 'before:today'],
            'Email' => ['required', 'email', 'max:128', Rule::unique('clients', 'Email')],
            'Phone' => ['required', 'min:7', 'max:32'],
            'Address' => ['required', 'max:255'],
            'City' => ['required', 'min:2', 'max:64'],
            'PostCode' => ['required', 'min:3', 'max:16'],
            'Notes' => ['nullable', 'max:1000'],
        ]);

        $userId = Auth::id();

        $client = new Client();
        $client->FirstName = $request->input('FirstName');
        $client->LastName = $request->input('LastName');
        $client->DateOfBirth = $request->input('DateOfBirth');
        $client->Email = $request->input('Email');
        $client->Phone = $request->input('Phone');
        $client->Address = $request->input('Address');
        $client->City = $request->input('City');
        $client->PostCode = $request->input('PostCode');
        $client->Notes = $request->input('Notes');
        $client->IsActive = true;
        $client->CreationDateTime = now();
        $client->EditDateTime = now();
        $client->CreatedByUserId = $userId;
        $client->UpdatedByUserId = $userId;

        $client->save();
    }

    /**
     * Update the specified client in storage.
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
            'DateOfBirth' => ['required', 'date', 'before:today'],
            'Email' => [
                'required',
                'email',
                'max:128',
                Rule::unique('clients', 'Email')->ignore($id, 'Id'),
            ],
            'Phone' => ['required', 'min:7', 'max:32'],
            'Address' => ['required', 'max:255'],
            'City' => ['required', 'min:2', 'max:64'],
            'PostCode' => ['required', 'min:3', 'max:16'],
            'Notes' => ['nullable', 'max:1000'],
        ]);

        $userId = Auth::id();

        $client = Client::findOrFail($id);
        $client->FirstName = $request->input('FirstName');
        $client->LastName = $request->input('LastName');
        $client->DateOfBirth = $request->input('DateOfBirth');
        $client->Email = $request->input('Email');
        $client->Phone = $request->input('Phone');
        $client->Address = $request->input('Address');
        $client->City = $request->input('City');
        $client->PostCode = $request->input('PostCode');
        $client->Notes = $request->input('Notes');
        $client->EditDateTime = now();
        $client->UpdatedByUserId = $userId;

        $client->save();
    }

    /**
     * Deactivate the specified client.
     *
     * @param int $id
     * @return void
     */
    public function deactivate(int $id): void
    {
        $client = Client::findOrFail($id);
        $client->IsActive = false;
        $client->EditDateTime = now();
        $client->DeletedByUserId = Auth::id();
        $client->DeletedDateTime = now();

        $client->save();
    }
}