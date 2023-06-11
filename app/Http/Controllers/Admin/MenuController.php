<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\CreateRequest;
use App\Http\Requests\Admin\Menu\UpdateRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.menu.index', [
          'menus' => Menu::all(),
          'categories' => Category::all(),
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
      // dd($request->all());
      // check if image is updated
      if ($request->hasFile('image')) {
        Storage::delete('public/' . $menu->image);
        $url = $request->file('image')->store('images/menu', 'public');
        $menu->image = $url;
      }

      $menu->update($request->all());
  
      return redirect()
        ->route('admin.menu.index')
        ->with('success', "Menu $request->name updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
      Storage::delete('public/' . $menu->image);
      $menu->delete();
      return redirect()
        ->route('admin.menu.index')
        ->with('success', "Menu $menu->name deleted successfully");
    }
}
