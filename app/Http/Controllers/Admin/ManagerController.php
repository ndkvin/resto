<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cashier\CreateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('pages.admin.manager.index', [
      'managers' => User::where('role', 'manager')->get(),
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
      'role' => 'manager',
    ]);

    // redirect
    return redirect()
      ->route('admin.manager.index')
      ->with('success', "Manager $request->name created succressfully");
  }

  /**
   * Display the specified resource.
   */
  public function show(User $manager)
  {
    return $manager;
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $manager)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $manager)
  {
    // update
    if (!$request->password) {
      $manager->update([
        'name' => $request->name,
        'email' => $request->email,
      ]);

      return redirect()
        ->route('admin.manager.index')
        ->with('success', "Cashier $manager->name updated succressfully");
    }

    $manager->update([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ]);

    // redirect
    return redirect()
      ->route('admin.manager.index')
      ->with('success', "Cashier $manager->name updated succressfully");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $manager)
  {

    $name = $manager->name ;
    // check if user used in orders
    if ($manager->orders()->count() > 0) {
      return redirect()
        ->route('admin.manager.index')
        ->withErrors(["manager $name cant be deleted because its used in orders"]);
    }

    $manager->delete();

    return redirect()
      ->route('admin.manager.index')
      ->with('success', "Manager $name deleted succressfully");
  }
}
