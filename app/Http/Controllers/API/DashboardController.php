use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;

public function dashboard()
{
    $totalOrders = Order::count();
    $totalOmzet = Order::sum('total');
    $ordersToday = Order::whereDate('created_at', today())->get();

    // Menghitung omzet per kategori
    $foodsOrders = Order::whereHas('menu', function($query) {
        $query->where('category_id', 1); // Asumsi foods category ID 1
    })->sum('total');

    $beveragesOrders = Order::whereHas('menu', function($query) {
        $query->where('category_id', 2); // Asumsi beverages category ID 2
    })->sum('total');

    $dessertsOrders = Order::whereHas('menu', function($query) {
        $query->where('category_id', 3); // Asumsi desserts category ID 3
    })->sum('total');

    // Chart omzet
    $chartData = Order::whereDate('created_at', today())
                      ->selectRaw('HOUR(created_at) as hour, SUM(total) as omzet')
                      ->groupBy('hour')
                      ->get();

    return view('dashboard', compact('totalOrders', 'totalOmzet', 'ordersToday', 'foodsOrders', 'beveragesOrders', 'dessertsOrders', 'chartData'));
}