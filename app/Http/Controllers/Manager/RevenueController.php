<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $menus = Menu::all();
        $order_items = OrderItem::all();
        $orders = Order::all();
        $earnings = $this->revenue();

        return view('pages.manager.revenue.index', [
            'menus' => $menus,
            'order' => $orders,
            'order_items' => $order_items,
            'earnings' => $earnings,
        ]);
    }
    public function revenue()
    {
        $earnings = DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(DB::raw('EXTRACT(MONTH FROM orders.created_at) AS month'), DB::raw('EXTRACT(YEAR FROM orders.created_at) AS year'), DB::raw('SUM(order_items.quantity * order_items.price_per_item) AS monthly_earnings'))
            ->where('orders.is_paid', 1)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        return $earnings;
    }

    public function show(OrderItem $orderItem)
    {
        return $orderItem;
    }
};