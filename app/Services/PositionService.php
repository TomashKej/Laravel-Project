<?php

namespace App\Services;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PositionService
{
    public function getAll(?string $search = null): Collection
    {
        $query = Position::with('employees')
            ->where('IsActive', true);

        if ($search != null && $search != '') {
            $query->where(function ($q) use ($search) {
                $q->where('Title', 'like', '%' . $search . '%')
                    ->orWhere('Description', 'like', '%' . $search . '%');
            });
        }

        return $query
            ->orderBy('Title')
            ->get();
    }

    public function getById(int $id): Position
    {
        return Position::with('employees')->findOrFail($id);
    }

    public function addNew(Request $request): void
    {
        $request->validate([
            'Title' => [
                'required',
                'min:2',
                'max:64',
                'unique:positions,Title',
            ],
            'Description' => [
                'nullable',
                'max:2000',
            ],
        ]);

        $position = new Position();
        $position->Title = $request->input('Title');
        $position->Description = $request->input('Description');
        $position->CreationDateTime = now();
        $position->EditDateTime = now();
        $position->IsActive = true;
        $position->save();
    }

    public function update(Request $request, int $id): void
    {
        $position = Position::findOrFail($id);

        $request->validate([
            'Title' => [
                'required',
                'min:2',
                'max:64',
                Rule::unique('positions', 'Title')->ignore($id, 'Id'),
            ],
            'Description' => [
                'nullable',
                'max:2000',
            ],
        ]);

        $position->Title = $request->input('Title');
        $position->Description = $request->input('Description');
        $position->EditDateTime = now();
        $position->save();
    }

    public function deactivate(int $id): void
    {
        $position = Position::findOrFail($id);
        $position->IsActive = false;
        $position->EditDateTime = now();
        $position->save();
    }

    public function getActivePositions(): Collection
    {
        return Position::where('IsActive', true)
            ->orderBy('Title')
            ->get();
    }
}