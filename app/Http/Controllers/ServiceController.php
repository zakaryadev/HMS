<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $positions = Position::all();
        return view('admin.services.index', [
            'services' => $services,
            'positions' => $positions
        ]);
    }

    public function edit(Service $service)
    {
        $positions = Position::all();
        return view('admin.services.edit', [
            'service' => $service,
            'positions' => $positions
        ]);
    }

    public function store(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'position_id' => 'required'
        ]);

        $service->create($validated);
        return redirect()->route('admin.services_index');
    }

    public function update(Service $service)
    {

        $validated = request()->validate([
            'name' => 'required',
            'price' => 'required',
            'position_id' => 'required'
        ]);

        $service->update($validated);
        return redirect()->route('admin.services_index');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services_index');
    }
}
