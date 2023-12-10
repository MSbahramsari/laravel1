<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $products = Product::all();
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
        Product::create([
                'product_name'=>$request->product_name,
                'price'=>$request->price,
                'amount_available'=>$request->amount_available,
                'explanation'=>$request->explanation,
                'sold_number'=>0
        ]);
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);


        return view('products.editProductMenue', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name'=>'required|max:20',
            'price'=>'required|integer|min:1000',
            'amount_available'=>'required|integer|min:1',
            'explanation'=>'required'
        ]);
        Product::find($id)->update([
                    'product_name'=>$request->product_name,
                    'price'=>$request->price,
                    'amount_available'=>$request->amount_available - $request->amount_sold,
                    'sold_number'=>$request->amount_sold,
                    'explanation'=>$request->explanation,
        ]);
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return back();
    }
}
