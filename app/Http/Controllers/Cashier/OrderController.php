<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\Order\CreateRequest;
use App\Http\Requests\Cashier\Order\UpdateRequest;
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
      ->leftJoin('reservations', 'reservations.order_id', '=', 'orders.id')
      ->select('orders.*', 'tables.name as table_name', 'users.name as cashier_name', 'reservations.name as customer_name')
      ->orderBy('orders.created_at', 'desc')
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

    if ($request->nominal < $table->price) {
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

      if ($request->nominal > 0) {
        Payment::create([
          'order_id' => $order->id,
          'amount' => $request->nominal,
          'payment_method' => $request->payment_method,
          'rekening' => $request->rekening,
        ]);
      }
      $this->storeMenu($request, $order->id);
      DB::commit();
      return redirect()
        ->route('cashier.order.index')
        ->with('success', 'Order successfully created');
    } catch (\Exception $e) {
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
      if ($request->amount[$index] > 0) {
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
  public function show(Order $order)
  {
    $payments = Payment::where('order_id', $order->id)->get();
    $totalPaid = 0;

    foreach ($payments as $payment) {
      $totalPaid += $payment->amount;
    }
    return view('pages.cashier.order.show', [
      'order' => $order,
      'menus' => OrderItem::with(['menu'])->where('order_id', $order->id)->get(),
      'payments' => $payments,
      'total_paid' => $totalPaid,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Order $order)
  {
    $menus = [];
    foreach (Category::all() as $category) {
      array_push($menus, [
        'category' => $category,
        'menus' => $this->getMenus($category->id),
      ]);
    }

    $payments = Payment::where('order_id', $order->id)->get();
    $totalPaid = 0;

    foreach ($payments as $payment) {
      $totalPaid += $payment->amount;
    }
    return view('pages.cashier.order.edit', [
      'order' => $order,
      'menus' => OrderItem::with(['menu'])->where('order_id', $order->id)->get(),
      'payments' => $payments,
      'total_paid' => $totalPaid,
      'tables' => Table::all(),
      'menu_list' => $menus,
      'table_price' => Table::find($order->table_id)->price,
    ]);
  }

  private function checkMenuOrder($menu_id, $order_id)
  {
    $orderItem = OrderItem::where('menu_id', $menu_id)->where('order_id', $order_id)->first();
    if ($orderItem) {
      return true;
    }
    return false;
  }
  
  private function validateUpdate($request, $orderId)
  {
    $table = Table::find($request->table_id);
    // total paid
    $payments = Payment::where('order_id', $orderId)->get();
    $totalPaid = 0;
    foreach($payments as $payment) {
      $totalPaid += $payment->amount;
    }
    $totalPaid += $request->nominal;

    if ($totalPaid < $table->price) {
      return true;
    }

    return false;
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateRequest $request, Order $order)
  {

    if ($this->validateUpdate($request, $order->id)) {
      return redirect()
        ->route('cashier.order.index')
        ->withErrors(['Nominal must be greater than table price']);
    }

    $total = $this->totalMenuPrice($request) + Table::find($request->table_id)->price;
    
    DB::beginTransaction();
    try {
      $order->update([
        'table_id' => $request->table_id,
        'total_price' => $total,
        'is_paid' => $request->is_paid,
      ]);
      foreach ($request->menu_id as $index => $menu_id) {
        if ($request->amount[$index] > 0 && !$this->checkMenuOrder($menu_id, $order->id)) {
          OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $menu_id,
            'quantity' => $request->amount[$index],
            'price_per_item' => Menu::find($menu_id)->price,
          ]);
        } else if ($this->checkMenuOrder($menu_id, $order->id)) {
          $orderItem = OrderItem::where('menu_id', $menu_id)->where('order_id', $order->id)->first();
          if ($request->amount[$index] == 0) {
            $orderItem->delete();
          } else {
            $orderItem->update([
              'quantity' => $request->amount[$index],
            ]);
          }
        }
      }

      if($request->nominal > 0) {
        Payment::create([
          'order_id' => $order->id,
          'amount' => $request->nominal,
          'payment_method' => $request->payment_method,
          'rekening' => $request->rekening,
        ]);
      }
      DB::commit();
      return redirect()
        ->route('cashier.order.index')
        ->with('success', 'Order successfully updated');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()
        ->route('cashier.order.edit', $order->id)
        ->withErrors([$e->getMessage()]);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
