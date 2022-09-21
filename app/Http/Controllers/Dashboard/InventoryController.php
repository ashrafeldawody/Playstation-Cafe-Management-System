<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\InventoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InventoryDataTable $dataTable)
    {
        return $dataTable->render('dashboard.inventory.index');
    }


    public function create()
    {
        $items = Item::all();
        return view('dashboard.inventory.create',compact('items'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'quantity' => 'required|numeric',
            'type' => 'required|in:BUY,SELL,RETURN,DEFECT,RETURN',
        ]);

        Inventory::create($request->all());
        return redirect()->route('inventory.index')->with('success','تمت الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
