<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        $products = DB::table('products')->get();
        return view('.products.productsData' , ['products'=>$products]) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): view
    {
        return \view('products.addProduct');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name'=>'required|max:20',
            'price'=>'required|integer|min:1000',
            'amount_available'=>'required|integer|min:1',
            'explanation'=>'required'
        ]);
        DB::table('products')
            ->insert([   'product_name'=>$request->product_name,
                'price'=>$request->price,
                'amount_available'=>$request->amount_available,
                'explanation'=>$request->explanation,
                'created_at'=>date('Y-m-d H:i:s'),
                'amount_sold'=>0]
            );
        return redirect()->route('products.index');
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
