<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Models\Category;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    return view('pages.admin.category.index', [
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
    $category = Category::create($request->all());

    return redirect()
      ->route('admin.category.index')
      ->with('success', "Category $category->name created successfully");
  }

  /**
   * Display the specified resource.
   */
  public function show(Category $category)
  {
    return $category;
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Category $category)
  {
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateRequest $request, Category $category)
  {
    // update category
    $category->update([
      'name' => $request->name,
    ]);

    return redirect()
      ->route('admin.category.index')
      ->with('success', "Category $request->name updated successfully");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Category $category)
  {
    $category->delete();
    return redirect()
      ->route('admin.category.index')
      ->with('success', "Category $category->name deleted successfully");
  }
}
