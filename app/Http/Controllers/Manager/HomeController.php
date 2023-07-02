<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    return view('pages.manager.index', [
      'menus' => $this->getPopularMenus(),
      'tables' => $this->getMostUsedTables(),
      'revenue' => $this->getRevenue(),
    ]);
  }

  public function getPopularMenus()
  {
    $popularMenus = DB::table('order_items')
      ->join('menus', 'order_items.menu_id', '=', 'menus.id')
      ->join('orders', 'order_items.order_id', '=', 'orders.id')
      ->where('orders.is_paid', 1)
      ->select(
        'menus.id AS menu_id',
        'menus.name AS menu_name',
        'menus.price AS menu_price',
        'menus.description AS menu_description',
        DB::raw('COUNT(*) AS total_orders')
      )
      ->groupBy('menus.id', 'menus.name', 'menus.price', 'menus.description')
      ->orderByDesc('total_orders')
      ->get();

    return $popularMenus;
  }

  public function getMostUsedTables()
  {
    $result = DB::table('tables')
      ->select('tables.id', 'tables.name', 'tables.price', 'tables.capacity', 'tables.is_paid', DB::raw('COUNT(*) AS used'))
      ->join('orders', 'tables.id', '=', 'orders.table_id')
      ->groupBy('tables.id', 'tables.name', 'tables.price', 'tables.capacity', 'tables.is_paid')
      ->orderByDesc('used')
      ->get();

    return $result;
  }

  public function getRevenue()
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
}
