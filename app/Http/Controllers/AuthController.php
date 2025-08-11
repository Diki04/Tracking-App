<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                    'data' => ['Token' => $token, 'User' => new UserResource($user)]
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
        // Pengambilan data user
       try {
         $user = Auth::user();

        return response()->json([
                    'message' => 'User Retrieved Successfully',
                    'data' => new UserResource($user)
                ], 200);
       } catch (Exception $e) {
            //throw $th;
            return response()->json([
                    'message' => 'User Retrieval Failed',
                    'data' => $e -> getMessage()
                ], 401);
        }
    }

    public function logout(){
        try {
         $user = Auth::user();
         $user->currentAccessToken()->delete();
        return response()->json([
                    'message' => 'User Logged Out Successfully',
                    'data' => null
                ], 200);
       } catch (Exception $e) {
            //throw $th;
            return response()->json([
                    'message' => 'User Logout Failed',
                    'data' => $e -> getMessage()
                ], 401);
        }
    }

    public function register(RegisterStoreRequest $request){
        // Validasi data yang diterima dari request
        $data = $request->validated();
        // Mulai transaksi database, supaya jika terjadi kesalahan tidak langsung di input ke db
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();
            // Membuat token untuk user yang baru dibuat
            $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();
            return response()->json([
                    'message' => 'User Registered Successfully',
                    'data' => ['token' => $token, 'user' => new UserResource($user)]
                ], 201);
        } catch (Exception $e) {
            //throw $th;
            return response()->json([
                    'message' => 'User Registration Failed',
                    'data' => $e -> getMessage()
                ], 401);
        }
    }
}
