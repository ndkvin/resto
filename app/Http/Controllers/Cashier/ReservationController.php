<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\Reservation\CreateRequest;
use App\Http\Requests\Cashier\Reservation\UpdateRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Table;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $reservations = Reservation::join('orders', 'orders.id', '=', 'reservations.order_id')
      ->join('tables', 'tables.id', '=', 'orders.table_id')
      ->select('reservations.*', 'tables.name as table_name')
      ->orderBy('orders.created_at', 'desc')
      ->get();

    return view('pages.cashier.reservation.index', [
      'tables' => Table::all(),
      'reservations' => $reservations,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  private function validateCreate(array $request)
  {
    $table = Table::find($request['table_id']);

    if ($request['amount'] < $table->price) {
      return true;
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CreateRequest $request)
  {
    $request = $request->all();

    if ($this->validateCreate($request)) {
      return redirect()
        ->route('cashier.reservation.index')
        ->withErrors(['Down Payment must be greater than table price']);
    }
    DB::beginTransaction();
    try {
      $order = Order::create([
        'table_id' => $request['table_id'],
        'created_by' => auth()->user()->id,
        'total_price' => $request['amount'],
      ]);

      Payment::create([
        'order_id' => $order->id,
        'amount' => $request['amount'],
        'payment_method' => 'cash',
      ]);

      Reservation::create([
        'order_id' => $order->id,
        'name' => $request['name'],
        'phone' => $request['phone'],
        'date' => $request['date'],
        'amount' => $request['amount'],
      ]);
      DB::commit();
      return redirect()
        ->route('cashier.reservation.index')
        ->with('success', 'Reservation created successfully');
    } catch (\Exception $e) {
      DB::rollback();
      return redirect()
        ->route('cashier.reservation.index')
        ->withErrors(['Down Payment must be greater than table price']);
    }
  }



  /**
   * Display the specified resource.
   */
  public function show(Reservation $reservation)
  {
    return $reservation::where('reservations.id', $reservation->id)
      ->join('orders', 'orders.id', '=', 'reservations.order_id')
      ->join('tables', 'tables.id', '=', 'orders.table_id')
      ->select('reservations.*', 'tables.name as table_name', 'tables.id as table_id')
      ->get();
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
  public function update(UpdateRequest $request, Reservation $reservation)
  {
    $request = $request->all();

    if ($this->validateCreate($request)) {
      return redirect()
        ->route('cashier.reservation.index')
        ->withErrors(['Down Payment must be greater than table price']);
    }

    DB::beginTransaction();
    try {

      Order::where('id', $reservation->order_id)->update([
        'total_price' => $request['amount'],
        'table_id' => $request['table_id'],
      ]);

      Payment::where('order_id', $reservation->order_id)->update([
        'order_id' => $reservation->id,
        'amount' => $request['amount'],
        'payment_method' => 'cash',
      ]);

      $reservation->update([
        'name' => $request['name'],
        'phone' => $request['phone'],
        'date' => $request['date'],
        'amount' => $request['amount'],
      ]);


      DB::commit();
      return redirect()
        ->route('cashier.reservation.index')
        ->with('success', 'Reservation updated successfully');
    } catch (\Exception $e) {
      DB::rollback();
      return redirect()
        ->route('cashier.reservation.index')
        ->withErrors(['Down Payment must be greater than table price']);
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
