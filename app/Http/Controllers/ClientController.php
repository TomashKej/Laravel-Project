<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClientService;

class ClientController extends Controller
{
    // Declare a private property to hold the ClientService instance
    private ClientService $clientService;

    // Constructor to initialize the ClientService instance
    public function __construct()
    {
        $this->clientService = new ClientService();
    }

    /**
     * Display a listing of the clients.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query('search');                    // Get the search term from the query parameters
        $clients = $this->clientService->getAll($search);       // Fetch clients using the ClientService
        
        // Return the 'clients.index' view with the fetched clients and the search term
        return view('clients.index', [
            'models' => $clients,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new client.
     *
     * @return \Illuminate\Http\Response
     */
    public function Create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created client in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function Store(Request $request)
    {
        $this->clientService->addNew($request);

        return redirect('/clients');
    }

    /**
     * Show the form for editing the specified client.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function Edit(int $id)
    {
        $client = $this->clientService->getById($id);

        return view('clients.edit', [
            'model' => $client,
        ]);
    }

    /**
     * Update the specified client in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function Update(Request $request, int $id)
    {
        $this->clientService->update($request, $id);

        return redirect('/clients');
    }

    /**
     * Remove the specified client from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function Delete(int $id)
    {
        $this->clientService->deactivate($id);

        return redirect('/clients');
    }
}
