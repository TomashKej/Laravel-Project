<?php

namespace App\Http\Controllers;

use App\Services\PositionService;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    private PositionService $service;

    public function __construct()
    {
        $this->service = new PositionService();
    }

    public function Index(Request $request)
    {
        $search = $request->query('search');

        return view('positions.index', [
            'models' => $this->service->getAll($search),
            'search' => $search,
        ]);
    }

    public function Create()
    {
        return view('positions.create');
    }

    public function Store(Request $request)
    {
        $this->service->addNew($request);

        return redirect('/positions')->with('success', 'Position has been created successfully.');
    }

    public function Edit(int $id)
    {
        $position = $this->service->getById($id);

        return view('positions.edit', [
            'model' => $position,
        ]);
    }

    public function Update(Request $request, int $id)
    {
        $this->service->update($request, $id);

        return redirect('/positions')->with('success', 'Position has been updated successfully.');
    }

    public function Details(int $id)
    {
        $position = $this->service->getById($id);

        return view('positions.details', [
            'model' => $position,
        ]);
    }

    public function Delete(int $id)
    {
        $this->service->deactivate($id);

        return redirect('/positions')->with('success', 'Position has been deactivated successfully.');
    }
}