<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function login(Request $request) {
        try {
            $request->validate([
              'username' => 'string|required',
              'password' => 'required'
            ]);

            $credentials = request(['username', 'password']);
            if (!Auth::attempt($credentials)) {
              return response()->json([
                'status_code' => 401,
                'message' => 'Unauthorized'
              ], 401);
            }
            $user = User::where('username', $request->username)->first();
            if ( !Hash::check($request->password, $user->password, [])) {
               throw new \Exception('Error in Login');
            }
            $tokenResult = $user->createToken('authToken')->accessToken;

            return response()->json([
              'status_code' => 200,
              'access_token' => $tokenResult,
              'token_type' => 'Bearer',
            ]);
          } catch (Exception $error) {
            return response()->json([
              'status_code' => 422,
              'message' => 'Unprocessed Entities',
              'error' => $error,
            ], 422);
          }
    }



    public function register(Request $request) {
        $data = $request->validate([
            'username' => 'string|required|unique:users|min:3',
            'name' => 'string|required|min:3',
            'password' => 'string|required|confirmed'
        ]);

        $user = User::create($data);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'user' => $user,
            'access_token' => $accessToken
        ]);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        return \response('Logged out', 200);
    }
}
