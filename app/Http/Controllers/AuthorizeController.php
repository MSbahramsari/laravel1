<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthorizeController extends Controller
{
    public function loginUser(LoginUserRequest $request){

        try {

            if (!Auth::attempt($request->only(['email','password']))){
                return response()->json([
                    'status'=>false,
                    'massage'=>'user not found',
                ], 401);
            }
            $user = User::where('email' , $request->email)->first();

            return response()->json([
                'status'=>true,
                'massage'=>'user login seccsasfullhy',
                'token'=>$user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'massage'=>$th->getMessage(),
            ], 500);
        }
    }
    public function  registerUser(RegisterUserRequest $request){
        try {

            $user = User::create([
                'user_name'=>$request->user_name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);
            $token = $user->createToken("API TOKEN")->plainTextToken;
            return response()->json([
                'status'=>true,
                'massage'=>'user register seccsasfullhy',
                'token'=> $token
            ], 200);
        } catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'massage'=>$th->getMessage(),
            ], 500);
        }


    }
}

