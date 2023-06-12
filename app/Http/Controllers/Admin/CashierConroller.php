<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cashier\CreateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class CashierConroller extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('pages.admin.cashier.index', [
      'cashiers' => User::where('role', 'cashier')->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CreateRequest $request)
  {
    // store
    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'role' => 'cashier',
    ]);

    // redirect
    return redirect()
      ->route('admin.cashier.index')
      ->with('success', "Cashier $request->name created succressfully");
  }

  /**
   * Display the specified resource.
   */
  public function show(User $cashier)
  {
    return $cashier;
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $cashier)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $cashier)
  {
    // update
    if (!$request->password) {
      $cashier->update([
        'name' => $request->name,
        'email' => $request->email,
      ]);

      return redirect()
        ->route('admin.cashier.index')
        ->with('success', "Cashier $cashier->name updated succressfully");
    }

    $cashier->update([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ]);

    // redirect
    return redirect()
      ->route('admin.cashier.index')
      ->with('success', "Cashier $cashier->name updated succressfully");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $cashier)
  {
    // check if user used in orders
    if ($cashier->orders()->count() > 0) {
      return redirect()
        ->route('admin.cashier.index')
        ->with('error', "Cashier $cashier->name can't be deleted because it's used in orders");
    }

    $cashier->delete();

    return redirect()
      ->route('admin.cashier.index')
      ->with('success', "Cashier $cashier->name deleted succressfully");
  }
}
