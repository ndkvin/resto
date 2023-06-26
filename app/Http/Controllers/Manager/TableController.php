<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\Table\CreateRequest;
use App\Http\Requests\Manager\Table\UpdateRequest;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::all();
        $mostUsedTables = $this->getMostUsedTables();

        return view('pages.manager.table.index', [
            'tables' => $tables,
            'mostUsedTables' => $mostUsedTables,
        ]);
    }

    public function getMostUsedTables()
    {
        $result = DB::table('tables')
            ->select('tables.id', 'tables.name', 'tables.price', 'tables.capacity', 'tables.is_paid', DB::raw('COUNT(*) AS used'))
            ->join('orders', 'tables.id', '=', 'orders.table_id')
            ->groupBy('tables.id', 'tables.name', 'tables.price', 'tables.capacity', 'tables.is_paid')
            ->orderByDesc('used')
            ->get();

        return $result;
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
        Table::create($request->validated());

        // redirect
        return redirect()
          ->route('manager.table.index')
          ->with('success', "table $request->name created succressfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        return $table;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Table $table)
    {
        // update
        $table->update($request->all());

        // redirect
        return redirect()
          ->route('manager.table.index')
          ->with('success', "table $table->name updated succressfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    { 
        if ($table->orders()->count() > 0) {
            return redirect()
              ->route('manager.table.index')
              ->with('error', "table $table->name used in orders, cannot delete");
        }
        // delete
        $table->delete();
        //redirect
        return redirect()
          ->route('manager.table.index')
          ->with('success', "table $table->name deleted succressfully");
    }
}
