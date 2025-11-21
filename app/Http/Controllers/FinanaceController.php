<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        // Filters
        $search = $request->search;
        $method = $request->method;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        $payments = Payment::with(['user', 'loan'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhere('reference', 'like', "%{$search}%");
            })
            ->when($method, function ($q) use ($method) {
                $q->where('method', $method);
            })
            ->when($dateFrom, function ($q) use ($dateFrom) {
                $q->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($q) use ($dateTo) {
                $q->whereDate('created_at', '<=', $dateTo);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)        // 👈 PAGINATION ENABLED
            ->appends($request->query()); // Keep filters across pages

        return view('admin.finance.index', compact(
            'payments',
            'search',
            'method',
            'dateFrom',
            'dateTo'
        ));
    }
}
