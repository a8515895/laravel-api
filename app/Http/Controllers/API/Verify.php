<?php

namespace App\Http\Controllers\API;
use JWTAuth;
use JWTFactory;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class Verify extends Controller
{
    // NEW 
        public function __construct()
        {
            // $this->middleware('auth:api');
        }
        public function login(Request $request)
        {
            $credentials = $request->only($request->type,'password');
            if ($token = Auth::guard('api')->attempt($credentials)) {
                return $this->respondWithToken($token);
            }
            return array('status'=> false,'err'=>"Sai tên đăng nhập");
        }
        public function me()
        {
            return response()->json($this->guard()->user());
        }
        public function logout()
        {
            $this->guard()->logout();
            return response()->json(['message' => 'Successfully logged out']);
        }
        public function refresh()
        {
            return $this->respondWithToken($this->guard()->refresh());
        }
        protected function respondWithToken($token)
        {
            return response()->json([
                'status'=>true,
                'access_token' => $token,
                'token_type' => 'bearer',
                'user'=>$this->me(),
                'level'=>$this->guard()->user()->level,
                'expires_in' => auth('api')->factory()->getTTL()
            ]);
        }
        public function guard()
        {
            return Auth::guard('api');
        }
}
