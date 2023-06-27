<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

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
        foreach(Category::all() as $category) {
          array_push($menus, [
            'category' => $category,
            'menus' => $this->getMenus($category->id),
          ]);
        } 

        return view('pages.cashier.order.create', [
          'menus' => $menus,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
