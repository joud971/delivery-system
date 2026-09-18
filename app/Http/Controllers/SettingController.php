<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('manage-settings'), 403);

        $settings = \App\Models\Setting::all();

        return view('settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('manage-settings'), 403);

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'default_delivery_fee' => 'required|numeric|min:0',
        ]);

        foreach (['company_name', 'default_delivery_fee'] as $key) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $validated[$key]]);
        }

        return redirect()->route('settings.index')->with('success', 'تم حفظ الإعدادات');
    }
}
