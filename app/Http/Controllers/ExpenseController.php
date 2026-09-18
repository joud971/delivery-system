<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('manage-finances'), 403);
        $expenses = Expense::with('user')->latest('expense_date')->paginate(20);
        return view('expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('manage-finances'), 403);
        Expense::create($request->validate(['category' => 'required|string|max:100', 'amount' => 'required|numeric|min:0', 'description' => 'nullable|string', 'expense_date' => 'required|date'] ) + ['incurred_by_user_id' => auth()->id(), 'status' => 'approved']);
        return back()->with('success', 'تم تسجيل المصروف');
    }
}
