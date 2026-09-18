<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Driver::class);
        $drivers = Driver::with('workSessions')->withCount('orders')->latest()->paginate(12);

        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        $this->authorize('create', Driver::class);

        return view('drivers.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Driver::class);
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:30|unique:drivers,phone',
            'license_number' => 'nullable|string',
            'vehicle_type' => 'nullable|string',
            'vehicle_plate' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        Driver::create($validated + [
            'status' => $validated['status'] ?? 'active',
            'is_available' => true,
        ]);

        return redirect()->route('drivers.index')->with('success', 'تمت إضافة السائق بنجاح');
    }

    public function show(string $id)
    {
        $driver = Driver::with(['orders', 'workSessions'])->findOrFail($id);
        $this->authorize('view', $driver);

        return view('drivers.show', compact('driver'));
    }

    public function edit(string $id)
    {
        $driver = Driver::findOrFail($id);
        $this->authorize('update', $driver);

        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, string $id)
    {
        $driver = Driver::findOrFail($id);
        $this->authorize('update', $driver);
        $validated = $request->validate([
            'name' => 'required|string|max:120', 'phone' => 'required|string|max:30|unique:drivers,phone,'.$driver->id,
            'license_number' => 'nullable|string|max:100', 'vehicle_type' => 'nullable|string|max:50',
            'vehicle_plate' => 'nullable|string|max:50', 'status' => 'nullable|in:active,inactive', 'is_available' => 'boolean',
        ]);
        $driver->update($validated);

        return redirect()->route('drivers.index')->with('success', 'تم تحديث السائق');
    }

    public function destroy(string $id)
    {
        $driver = Driver::findOrFail($id);
        $this->authorize('delete', $driver);
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'تم حذف السائق');
    }
}
