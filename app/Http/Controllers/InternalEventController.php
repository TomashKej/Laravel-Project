<?php

namespace App\Http\Controllers;

use App\Models\InternalEvent;
use App\Services\InternalEventService;
use Illuminate\Http\Request;

class InternalEventController extends Controller
{
    private InternalEventService $service;
    public function __construct()
    {
        $this->service = new InternalEventService();
        
    }

    public function Index()
    {
        $event = $this->service->getAll();
        return view('internal_events.index', ['models' => $event]);
    }
    //
}
