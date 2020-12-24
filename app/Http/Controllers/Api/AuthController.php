<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|min:10|max:15|unique:users,phone',
            'woreda' => 'required|integer|min:1|max:30',
            'password' => 'required|string|min:6|confirmed'
        ]);
        if ($validator->fails()) {
            return response([
                'errors'=>$validator->errors()->messages(),
                'message' => 'The given data was invalid!'
            ], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token, 'user' => $user];
        return response($response, 200);
    }

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response([
                'errors'=>$validator->errors()->all(),
                'message' => 'The given data was invalid!'
            ], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token, 'user' => $user];
                return response($response, 200);
            } else {
                $response = ["message" => "Incorrect Password!"];
                return response($response, 401);
            }
        } else {
            $response = ["message" =>'User does not exist!'];
            return response($response, 401);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $token->delete();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
