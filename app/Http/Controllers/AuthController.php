<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    public function login(Request $request){
        try {
            if(!Auth::guard('web')->attempt($request->only('email', 'password'))){
                return response()->json([
                    'message' => 'Unauthorized',
                    'data' => null
                ], 401);
            }
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                    'message' => 'Login Success',
                    'data' => ['Token' => $token, 'User' => $user]
                ], 200);
        } catch (Exception $e) {
            //throw $th;
            return response()->json([
                    'message' => 'Login Failed',
                    'data' => $e -> getMessage()
                ], 401);
        }
    }
    public function me(){
        $user = Auth::user();
    }
}
