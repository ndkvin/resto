<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Support\Str;

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



  function createUniqueSlug($input)
  {
    $slug = Str::slug($input);
    $uniqueSlug = $slug;
    $counter = 1;

    while (Category::where('slug', $uniqueSlug)->exists()) {
      $uniqueSlug = $slug . '-' . $counter;
      $counter++;
    }

    return $uniqueSlug;
  }
  /**
   * Store a newly created resource in storage.
   */
  public function store(CreateRequest $request)
  {

    $category = Category::create([
      'name' => $request->name,
      'slug' => $this->createUniqueSlug($request->name),
    ]);

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
    $data = $request->all();

    // jika nama berbeda
    if ($request->name != $category->name) {
      $data['slug'] = $this->createUniqueSlug($request->name);
    }

    // update category
    $category->update($data);

    return redirect()
      ->route('admin.category.index')
      ->with('success', "Category $request->name updated successfully");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Category $category)
  {

    // cehek catetgory menu if exits
    if ($category->menus()->count() > 0) {
      return redirect()
        ->route('admin.category.index')
        ->withErrors(["Category $category->name cant be deleted because it has a menu"]);
    }

    $category->delete();
    return redirect()
      ->route('admin.category.index')
      ->with('success', "Category $category->name deleted successfully");
  }
}
