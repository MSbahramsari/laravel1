<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_product;
use App\Models\Product;
use App\Models\User;
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
        $orders = Order::with('products')->with('user')->get();
        return view('.orders.ordersData', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $users = User::where('phone_number','!=','null')->get();
        return view('orders.addOrder', ['users' => $users, 'products' => $products]);

    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $products = Product::all();
        $totalPrice = 0;
        $data = $request->all();
        $pcounts = [];
        foreach ($products as $product) {
            foreach ($data as $key => $value) {
                if ($product->id == $key) {
                    $price = $product->price;
                    $amount = $request->$key;
                    $sum = $price * $amount;
                    $totalPrice += $sum;
                    $pro_count = array('product_id'=>$product->id , 'count'=>$amount);
                }
            }
            $pcounts []= $pro_count;

        }

            $order = Order::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'total_price' => $totalPrice,
            ]);
        foreach ($pcounts as $pcount){
            if ($pcount['count']){

                $order->products()->attach($pcount['product_id'], ['count' => $pcount['count']]);
            }
        }



        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::all();
        $products = Product::all();
        $orders = Order::with('products')->where('id', $id)->get();
        foreach ($orders as $order)


            return view('orders.editOrderMenue', ['users' => $users, 'products' => $products, 'order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
//        $pivot = Order_product::where('order_id' , $id)->forcedelete();
        $products = Product::all();
        $totalPrice = 0;
        $data = $request->all();
        $pc = [];
        foreach ($products as $product) {
            foreach ($data as $key => $value) {
                if ($product->id == $key) {
                    $price = $product->price;
                    $amount = $request->$key;
                    $sum = $price * $amount;
                    $totalPrice += $sum;
                    $count = (int)$amount;
                    $poc = array('product_id' => $product->id, 'count' => $count);
                }
            }
            $pc [] = $poc;
        }
        $order = Order::findOrFail($id);
        foreach ($pc as $key => $pce) {
            if ($key == 0)
                $order->products()->syncWithPivotValues([$pce['product_id']], ['count' => $pce['count']]);
            else
                $order->products()->attach($pce['product_id'], ['count' => $pce['count']]);
        }
        $order->update(['total_price' => $totalPrice,]);

//        }



        return redirect()->route('orders.index');

    }
//                }
//            }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        $order->delete();
        $pivot = Order_product::where('order_id', $id);
        $pivot->delete();
        return back();
    }
}

