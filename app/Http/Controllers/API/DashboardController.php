<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $tanggal = $request->query('tanggal', Carbon::today()->toDateString());

        $totalOrder = Order::whereDate('created_at', $tanggal)->count();
        $totalOmzet = Transaction::whereDate('created_at', $tanggal)->sum('total');

        $menuSummary = [
            'foods' => Order::whereHas('menu', fn($q) => $q->where('category_id', 1))
                            ->whereDate('created_at', $tanggal)->count(),
            'beverages' => Order::whereHas('menu', fn($q) => $q->where('category_id', 2))
                            ->whereDate('created_at', $tanggal)->count(),
            'desserts' => Order::whereHas('menu', fn($q) => $q->where('category_id', 3))
                            ->whereDate('created_at', $tanggal)->count(),
        ];

        return response()->json([
            'tanggal' => $tanggal,
            'total_order' => $totalOrder,
            'total_omzet' => $totalOmzet,
            'menu_summary' => $menuSummary,
        ]);
    }

}



