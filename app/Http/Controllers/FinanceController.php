<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('manage-finances'), 403);

        $today = Carbon::today();
        $dailyOrderCount = Order::whereDate('created_at', $today)->count();
        $deliveryFeesTotal = (float) Order::sum('delivery_fee');
        $received = (float) Payment::where('status', 'paid')->sum('amount');
        $expenses = (float) Expense::sum('amount');
        $profit = $received - $expenses;
        $outstanding = max(0, $deliveryFeesTotal - $received);
        $latestExpenses = Expense::with('user')->latest('expense_date')->limit(12)->get();
        $latestOrders = Order::with(['customer', 'payments'])->latest()->limit(12)->get();

        return view('finance.index', compact(
            'dailyOrderCount',
            'deliveryFeesTotal',
            'received',
            'expenses',
            'profit',
            'outstanding',
            'latestExpenses',
            'latestOrders'
        ));
    }
}
