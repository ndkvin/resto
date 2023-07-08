<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\Reservation\CreateRequest;
use App\Http\Requests\Cashier\Reservation\UpdateRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Table;
use DateTime;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    $dateString = $request['date'];
    $timestamp = strtotime($dateString);
    $dateTime = new DateTime("@$timestamp");
    $past = clone $dateTime;
    $past->modify('-2 hours');
    $order = $dateTime;
    $future = clone $dateTime;
    $future->modify('+2 hours');

    $now = Carbon::now('Asia/Jakarta');

    if($order < $now){
      return redirect()
        ->route('cashier.reservation.index')
        ->withErrors(['Cannot reserve table in the past']);
    }
  
    $reservation = Reservation::join('orders', 'orders.id', '=', 'reservations.order_id')
      ->where('reservations.date', ">=", $past)
      ->where('table_id', $request['table_id'])
      ->get();
   
    foreach ($reservation as $res) {
      if ($res->date <= $future) {
        return redirect()
          ->route('cashier.reservation.index')
          ->withErrors(['Table is already reserved']);
      }
    }

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
        'total_price' => Table::find($request['table_id'])->price,
      ]);

      // if paymet is greather than 0
      if ($request['amount'] > 0) {
        Payment::create([
          'order_id' => $order->id,
          'amount' => Table::find($request['table_id'])->price,
          'payment_method' => $request['payment_method'],
          'rekening' => $request['rekening'],
        ]);
      }

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
      ->leftJoin('payments', 'payments.order_id', '=', 'orders.id')
      ->select('reservations.*', 'tables.name as table_name', 'tables.id as table_id', 'payments.payment_method as payment_method', 'payments.rekening as rekening')
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


    $dateString = $request['date'];
    $timestamp = strtotime($dateString);
    $dateTime = new DateTime("@$timestamp");
    $past = clone $dateTime;
    $past->modify('-2 hours');
    $order = $dateTime;
    $future = clone $dateTime;
    $future->modify('+2 hours');

    $now = Carbon::now('Asia/Jakarta');

    if($order < $now){
      return redirect()
        ->route('cashier.reservation.index')
        ->withErrors(['Cannot reserve table in the past']);
    }

    $a = Reservation::join('orders', 'orders.id', '=', 'reservations.order_id')
      ->where('reservations.date', ">=", $past)
      ->where('table_id', $request['table_id'])
      ->whereNot('orders.id', $reservation->order_id)
      ->get();

    foreach ($a as $res) {
      if ($res->date <= $future) {
        return redirect()
          ->route('cashier.reservation.index')
          ->withErrors(['Table is already reserved']);
      }
    }
    $payment = Payment::where('order_id', $reservation->order_id)->exists();

    DB::beginTransaction();
    try {

      Order::where('id', $reservation->order_id)->update([
        'total_price' => $request['amount'],
        'table_id' => $request['table_id'],
      ]);

      if($payment &&  $request['amount'] > 0) {
        Payment::where('id', Payment::where('order_id', $reservation->order_id)->first()->id)->update([
          'amount' => $request['amount'],
          'payment_method' => $request['payment_method'],
          'rekening' => $request['rekening'],
        ]);
      } else if($request['amount']>0) {
        Payment::create([
          'order_id' => $reservation->order_id,
          'amount' => $request['amount'],
          'payment_method' => $request['payment_method'],
          'rekening' => $request['rekening'],
        ]);
      }

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
