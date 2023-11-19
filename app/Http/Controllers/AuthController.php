<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;


class AuthController extends Controller
{
    
    public function register(Request $request){
        $validated = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required|confirmed|min:6'
        ]);
        $user=User::create($validated);
        return response()->json([
            'data'=>$user,'access_token'=>$user->createToken('api_token')
            ->plainTextToken,'token_type'=>'Bearer',
        ],201);
    }

    public function login(Request $request){
        $validated=$request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(! Auth::attempt($validated)){
            return response()->json(['message'=>'login information invaild'],401);
        }

        $user=User::where('email',$validated['email'])->first();

        return response()->json([
            'access_token'=>$user->createToken('api_token')->plainTextToken,'token_type'=>'Bearer',
        ]);
    }
}
