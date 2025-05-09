<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['details.menu.category']);

        if ($request->filled('category')) {
            $query->whereHas('details.menu.category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->filled('order_type')) {
            $query->where('order_type', $request->order_type);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $transactions = $query->get();

        return response()->json($transactions);
    }
}
