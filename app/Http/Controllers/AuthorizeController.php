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
                return redirect()->back([
                    'status'=>false,
                    'massage'=>'user not found',
                ], 401);
            }
            $user = User::where('email' , $request->email)->first();
            $token = $user->createToken("API TOKEN")->plainTextToken;
            session()->put('token', []);
            session()->push('token', $token);
            return redirect()->route('workplace');

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
            return redirect()->route('view.login');

        } catch(\Throwable $th){
            return response()->json([
                'status'=>false,
                'massage'=>$th->getMessage(),
            ], 500);
        }


    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens->each(function ($token, $key) {
            $token->delete();
            Auth::logout();
        });
        return redirect('/login');
    }
}

