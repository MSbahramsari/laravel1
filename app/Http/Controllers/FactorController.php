<?php

namespace App\Http\Controllers;

use App\Models\Factor;
use App\Http\Requests\StoreFactorRequest;
use App\Http\Requests\UpdateFactorRequest;
use App\Models\Order;

class FactorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $factors = Factor::with('order.products' , 'order.user')->get();
        return view('factors.factorsData' , ['factors'=>$factors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::all();
        return view('factors.addFactor' , ['orders'=>$orders]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFactorRequest $request)
    {
        Factor::create([
            'order_id'=>$request->order_id,
            'total_pay'=>$request->total_pay
        ]);
        return redirect(route('factors.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Factor $factor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Factor $id)
    {

        $orders = Order::all();
        return view('factors.editFactorMenue' , ['factor'=>$id , 'orders'=>$orders]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFactorRequest $request, Factor $id)
    {
        Factor::find($id->id)->update([
            'order_id'=>$request->order_id,
            'total_pay'=>$request->total_pay,
        ]);
        return redirect(route('factors.index'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Factor $id)
    {
        $factor = Factor::find($id->id);
        $factor->delete();
        return back();

    }
}
