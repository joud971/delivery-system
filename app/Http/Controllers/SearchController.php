<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        abort_unless(auth()->user()->can('view-operational-search'), 403);

        $term = trim((string) $request->string('q'));
        abort_if(mb_strlen($term) < 2, 422, 'اكتب حرفين على الأقل للبحث.');

        return view('search.index', [
            'term' => $term,
            'orders' => Order::with(['customer', 'driver'])->where('order_number', 'like', "%{$term}%")->orWhereHas('customer', fn ($query) => $query->where('name', 'like', "%{$term}%")->orWhere('phone', 'like', "%{$term}%"))->limit(20)->get(),
            'customers' => Customer::where('name', 'like', "%{$term}%")->orWhere('phone', 'like', "%{$term}%")->limit(20)->get(),
            'drivers' => Driver::where('name', 'like', "%{$term}%")->orWhere('phone', 'like', "%{$term}%")->limit(20)->get(),
        ]);
    }
}
