<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\Reservation\CreateRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.cashier.reservation.index', [
          'tables' => Table::all(),
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

        if($request['amount'] < $table->price) {
          return 1;
        }

        return 0;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
          $request = $request->all();
  
          if($this->validateCreate($request)) {
            return redirect()
              ->route('cashier.reservation.index')
              ->with('success', "amount must be greater than table price");
          }

          $table = Table::find($request['table_id']);
          return $request['amount'] . $table->price;
          
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

          return redirect()
            ->route('cashier.reservation.index')
            ->with('success', 'reservation created successfully');
            echo "6";


            return redirect()
              ->route('cashier.reservation.index')
              ->with('error', "asasdfasas");
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
