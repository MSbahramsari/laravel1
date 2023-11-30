<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        $users = DB::table('users')
            ->where('status','=','enable')
            ->get();
        return view('.users.usersData', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): view

    {
        return view('users.addUser');

    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'user_name'=>'required|max:20|alpha_dash:ascii',
            'last_name'=>'required|max:255|alpha_dash:ascii',
            'first_name'=>'required|max:255|alpha_dash:ascii' ,
            'age'=>'required|min:18|',
            'gender'=>'required',
            'email'=>'required',
            'phone_number'=>'required|min:11|max:11',
            'password'=>'required|min:8',
            'address'=>'required',
            'post_code'=>'required|min:10|max:255',
            'province'=>'required',
            'city'=>'required',
        ]);
//
            DB::table('users')->insert([
                'user_name'=>$request->user_name,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'age'=>$request->age,
                'gender'=>$request->gender,
                'email'=>$request->email,
                'phone_number'=>$request->phone_number,
                'password'=>md5($request->password),
                'address'=>$request->address,
                'post_code'=>$request->postal_code,
                'province'=>$request->province,
                'city'=>$request->city,
                'status'=>"enable",
                'created_at'=>date('Y-m-d H:i:s'),
            ]);
            return redirect()->route('users.index');
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
    public function edit(string $id): view
    {
        $users = DB::table('users')->where('id', $id) -> first();


        return view('users.editUser', ['user' => $users]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $users = DB::table('users')
            ->where('id',$id)
            ->update([

            ]);



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update(['status' => 'disable']);
        return back();
    }


}
