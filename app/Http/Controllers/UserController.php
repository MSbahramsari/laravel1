<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        $users = DB::table('users')->get();
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
     */
    public function store(Request $request)
    {
        {
            $user_name = $request->input('user_name');
            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $age = $request->input('age');
            $gender = $request->input('gender');
            $email = $request->input('email');
            $phone_number = $request->input('phone_number');
            $password = md5($request->input('password'));
            $address = $request->input('address');
            $postal_code = $request->input('postal_code');
            $province = $request->input('province');
            $city = $request->input('city');
            DB::insert('insert into users (user_name , first_name , last_name , age , gender , email , phone_number , password , address , post_code , province , city , status , created_at)
                values (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?)',
                [$user_name , $first_name , $last_name ,$age ,$gender,$email,$phone_number,$password,$address,$postal_code,$province,$city,'enable',date('Y-m-d H:i:s')]);

            return redirect()->route('users.index');
        }
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
        $user = DB::select('select * from users where id = ?', [$id]);

        return view('users.editUser', ['user' => $user]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $users = DB::update(
            'update users set  where name = ?',
            ['Anita']
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
