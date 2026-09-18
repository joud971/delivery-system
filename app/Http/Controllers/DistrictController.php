<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('manage-settings'), 403);
        $districts = District::withCount('orders')->orderBy('name')->paginate(20);
        return view('districts.index', compact('districts'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('manage-settings'), 403);
        District::create($request->validate(['name' => 'required|string|max:100', 'city' => 'nullable|string|max:100', 'delivery_fee' => 'required|numeric|min:0']));
        return back()->with('success', 'تمت إضافة المنطقة');
    }

    public function update(Request $request, District $district)
    {
        abort_unless(auth()->user()->can('manage-settings'), 403);
        $district->update($request->validate(['name' => 'required|string|max:100', 'city' => 'nullable|string|max:100', 'delivery_fee' => 'required|numeric|min:0', 'status' => 'required|in:active,inactive']));
        return back()->with('success', 'تم تحديث المنطقة');
    }

    public function destroy(District $district)
    {
        abort_unless(auth()->user()->can('manage-settings'), 403);
        abort_if($district->orders()->exists(), 422, 'لا يمكن حذف منطقة مرتبطة بطلبات.');
        $district->delete();
        return back()->with('success', 'تم حذف المنطقة');
    }
}
