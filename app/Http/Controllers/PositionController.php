<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();
        return view('admin.positions.index', [
            'positions' => $positions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:positions,name|string|max:255',
        ]);
        $position = Position::create([
            'name' => $validated['name'],
        ]);
        return redirect()->route('admin.positions_index');
    }

    public function edit(Position $position)
    {
        return view('admin.positions.edit', [
            'position' => $position,
        ]);
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|unique:positions,name|string|max:255',
        ]);
        $position->update([
            'name' => $validated['name'],
        ]);
        return redirect()->route('admin.positions_index');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('admin.positions_index');
    }
}
