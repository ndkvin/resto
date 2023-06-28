<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\Order\CreateRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $orders = Order::join('tables', 'tables.id', '=', 'orders.table_id')
      ->join('users', 'users.id', '=', 'orders.created_by')
      ->select('orders.*', 'tables.name as table_name', 'users.name as cashier_name')
      ->get();

    return view('pages.cashier.order.index', [
      'orders' => $orders,
    ]);
  }

  private function getMenus(string $categoryId)
  {
    return Menu::where('category_id', $categoryId)->get();
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $menus = [];
    foreach (Category::all() as $category) {
      array_push($menus, [
        'category' => $category,
        'menus' => $this->getMenus($category->id),
      ]);
    }

    return view('pages.cashier.order.create', [
      'menus' => $menus,
      'tables' => Table::all(),
    ]);
  }
  private function validateInput($request)
  {
    $table = Table::find($request->table_id);

    if($request->nominal < $table->price) {
      return true;
    }
  }
  /**
   * Store a newly created resource in storage.
   */
  public function store(CreateRequest $request)
  {
    if ($this->validateInput($request)) {
      return redirect()
        ->route('cashier.order.index')
        ->withErrors(['Nominal must be greater than table price']);
    }

    DB::beginTransaction();
    try {
      $total = $this->totalMenuPrice($request) + Table::find($request->table_id)->price;
      $order = Order::create([
        'created_by' => auth()->user()->id,
        'table_id' => $request->table_id,
        'total_price' => $total,
        'is_paid' => $request->is_paid,
      ]);

      if($request->nominal > 0) {
        Payment::create([
          'order_id' => $order->id,
          'amount' => $request->nominal,
          'payment_method' => $request->peyment_method,
          'rekening' => $request->rekening,
        ]);
      }
      $this->storeMenu($request, $order->id);
      DB::commit();
      return redirect()
        ->route('cashier.order.index')
        ->with('success', 'Order successfully created');
    } catch(\Exception $e) {
      DB::rollBack();
      return redirect()
        ->route('cashier.order.create')
        ->withErrors([$e->getMessage()]);
    }
  }

  private function totalMenuPrice($request)
  {
    $total = 0;
    foreach ($request->menu_id as $index => $menu_id) {
      $menu = Menu::find($menu_id);
      $total += $menu->price * $request->amount[$index];
    }

    return $total;
  }

  private function storeMenu($request, $orderId)
  {
    foreach ($request->menu_id as $index => $menu_id) {
      if($request->amount[$index] > 0) {
        OrderItem::create([
          'order_id' => $orderId,
          'menu_id' => $menu_id,
          'quantity' => $request->amount[$index],
          'price_per_item' => Menu::find($menu_id)->price,
        ]);
      }
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
