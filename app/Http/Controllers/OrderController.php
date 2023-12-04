<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use function Laravel\Prompts\select;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pivot = DB::table('order_products')
            ->select('order_id','product_id','count')
            ->get();
        $products = DB::table('products')
            ->where('status', '=','enable')
            ->get();
        $orders = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.id','orders.title','orders.total_price','orders.explanations','orders.user_id', 'users.first_name','users.last_name','users.email')
            ->where('orders.status', '=','enable')
            ->get();
        return view('.orders.ordersData' , ['orders'=>$orders , 'pivot'=>$pivot , 'products'=>$products]) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = DB::table('products')
            ->where('status', '=','enable')
            ->get();
        $users = DB::table('users')
            ->where('status','=','enable')
            ->get();
        return view('orders.addOrder', ['users' => $users , 'products'=>$products]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $products = DB::table('products')
            ->where('status', '=','enable')
            ->get();
        $totalPrice = 0;
        $data = $request->all();
        $productsIds = [];
        foreach ($products as $product){
            foreach ($data as $key =>$value ){
                if($product->id == $key){
                    $price = $product->price;
                    $amount = $request->$key;
                    $sum = $price * $amount;
                    $totalPrice += $sum;
                }
            }
            $productsIds []= $product->id;
        }
        DB::table('orders')->insert([
            'user_id'=>$request->user_id,
            'title'=>$request->title,
            'total_price'=>$totalPrice,
            'status'=>"enable",
            'created_at'=>date('Y-m-d H:i:s'),
        ]);
        $orderid = DB::getPdo()->lastInsertId();
            foreach ($productsIds as $productId){
                foreach ($data as $key =>$value ){
                    if($productId == $key) {
                        $amount = $request->$key;
                        if ($amount > 0) {
                            DB::table('order_products')->insert([
                                'order_id'=>$orderid,
                                'product_id'=> $productId,
                                'count'=> $amount,
                                'created_at'=>date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                }
            }

        return redirect('orders.index') ;
    }

    /**
     * Display the specified resource.
     */
    public function pro(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $products = DB::table('products')
            ->where('status', '=','enable')
            ->get();
        $pivot = DB::table('order_products')
            ->select('order_id','product_id','count')
            ->where('order_id', $id)
            ->get();
        $users = DB::table('users')
            ->where('status','=','enable')
            ->get();
        $orders = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('order_products', 'order_products.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_products.product_id')
            ->select('orders.id','orders.title','orders.total_price','orders.explanations','order_products.count','order_products.product_id','orders.user_id', 'users.first_name','users.last_name','users.email','products.product_name','products.price')
            ->where('order_id',$id)
            ->get();
        foreach ($orders as $order)



        return view('orders.editOrderMenue', ['users' => $users , 'products'=>$products , 'order'=>$order , 'pivot'=>$pivot]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::table('order_products')
            ->where('order_id',$id)
        ->delete();
        $products = DB::table('products')
            ->where('status', '=','enable')
            ->get();
        $totalPrice = 0;
        $data = $request->all();
        $productsIds = [];
        foreach ($products as $product){
            foreach ($data as $key =>$value ){
                if($product->id == $key){
                    $price = $product->price;
                    $amount = $request->$key;
                    $sum = $price * $amount;
                    $totalPrice += $sum;
                }
            }
            $productsIds []= $product->id;
        }
        DB::table('orders')
            ->where('id',$id)
            ->update([
            'total_price'=>$totalPrice,
        ]);
        foreach ($productsIds as $productId){
            foreach ($data as $key =>$value ){
                if($productId == $key) {
                    $amount = $request->$key;
                    if ($amount > 0) {
                        DB::table('order_products')
                            ->where('order_id',$id)
                            ->updateOrInsert([
                            'order_id'=>$id,
                            'product_id'=> $productId,
                            'count'=> $amount,
                            'created_at'=>date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
        }
        return redirect('order.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('orders')
            ->where('id', $id)
            ->update(['status' => 'disable']);
        return back();
    }
}

