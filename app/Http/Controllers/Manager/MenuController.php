<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\Menu\CreateRequest;
use App\Http\Requests\Manager\Menu\UpdateRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        $categories = Category::all();
        $orders = Order::all();
        $orderitem = OrderItem::all();
        $popularMenus = $this->getPopularMenus();

        return view('pages.manager.menu.index', [
            'menus' => $menus,
            'categories' => $categories,
            'order' => $orders,
            'orderitem' => $orderitem,
            'popularMenus' => $popularMenus,
        ]);
    }

    public function getPopularMenus()
    {
        $popularMenus = DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.is_paid', 1)
            ->select('menus.id AS menu_id',
            'menus.name AS menu_name',
            'menus.price AS menu_price',
            'menus.description AS menu_description',
            DB::raw('COUNT(*) AS total_orders'))
            ->groupBy('menus.id', 'menus.name', 'menus.price', 'menus.description')
            ->orderByDesc('total_orders')
            ->get();

        return $popularMenus;
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
        // store image
        $url = $request->file('image')->store('images/menu', 'public');

        $menu = $request->all();
        $menu['image'] = $url;
        $menu = Menu::create($menu);

        return redirect()
          ->route('admin.menu.index')
          ->with('success', "Menu $menu->name created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return $menu;
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
    public function update(UpdateRequest $request, Menu $menu)
    {
      $data = $request->all();

      if ($request->hasFile('image')) {
        Storage::delete('public/' . $menu->image);
        $url = $request->file('image')->store('images/menu', 'public');
        $data['image'] = $url;
      }

      $menu->update($data);

      return redirect()
        ->route('admin.menu.index')
        ->with('success', "Menu $menu->name updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
      // chec menu if used in order
      if ($menu->orders()->count() > 0) {
        return redirect()
          ->route('admin.menu.index')
          ->with('error', "Menu $menu->name used in order");
      }

      Storage::delete('public/' . $menu->image);
      $menu->delete();
      return redirect()
        ->route('admin.menu.index')
        ->with('success', "Menu $menu->name deleted successfully");
    }
}
