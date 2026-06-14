<?php

namespace App\Services;

use App\Models\InternalEvent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class InternalEventService
{
    public function getAll() : Collection
    {
        return InternalEvent::all();
    }
}
