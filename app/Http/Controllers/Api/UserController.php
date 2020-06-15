<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request){

        $credential = $request->only('email', 'password');
        if(Auth::attempt($credential)){ 
            $token = Str::random(80);
            Auth::user()->api_token = $token;
            Auth::user()->save();
            return response()->json(['token' => $token], 200);
        }
        return response()->json(['status' => 'Username and Password do not match'], 403);
    }
}
