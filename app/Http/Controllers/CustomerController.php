<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Customer::class);
        $customers = Customer::with('district')->withCount('orders')->latest()->paginate(12);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $this->authorize('create', Customer::class);
        $districts = \App\Models\District::where('status', 'active')->orderBy('name')->get();

        return view('customers.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Customer::class);
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:30|unique:customers,phone',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'district_id' => 'nullable|exists:districts,id',
            'status' => 'nullable|string',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'تمت إضافة العميل بنجاح');
    }

    public function show(string $id)
    {
        $customer = Customer::with(['orders', 'district'])->findOrFail($id);
        $this->authorize('view', $customer);

        return view('customers.show', compact('customer'));
    }

    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        $this->authorize('update', $customer);
        $districts = \App\Models\District::where('status', 'active')->orderBy('name')->get();

        return view('customers.edit', compact('customer', 'districts'));
    }

    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);
        $this->authorize('update', $customer);
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:30|unique:customers,phone,'.$customer->id,
            'email' => 'nullable|email|max:180',
            'address' => 'nullable|string|max:5000',
            'district_id' => 'nullable|exists:districts,id',
            'status' => 'nullable|in:active,inactive',
        ]);
        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'تم تحديث العميل');
    }

    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $this->authorize('delete', $customer);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'تم حذف العميل');
    }
}
