<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * @param Illuminate\Http\Request object
     * validate the inputs and create a user
     * @return json object with token and user
     */
    public function register(Request $request) {
        $customMessage = [
            'password.regex' => 'The password must containt at least one lowercase, one uppercase, one digit, and one special character.'
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|min:10|max:15|unique:users,phone',
            'woreda' => 'required|integer|min:1|max:30',
            'password' => 'required|string|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/'
        ], $customMessage);
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
        $response = ['token' => $token, 'user' => $user, 'success' => true, 'message' => 'Welcome, You have successfully registered.'];
        return response($response, 200);
    }

    /**
     * @param Illuminate\Http\Request object
     * validate the input sign in the user
     * @return json object with token and user
     */
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
            if(!$user->spammer) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token, 'user' => $user, 'success' => true, 'message' => 'You are successfully logged in.'];
                    return response($response, 200);
                }
                else {
                    $response = ["message" => "Incorrect Password!"];
                    return response($response, 401);
                }
            }
            else {
                $response = ["message" => "Account has been suspended due to spamming!"];
                return response($response, 401);
            }
        }
        else {
            $response = ["message" =>'User does not exist!'];
            return response($response, 401);
        }
    }

    /**
     * @param Illuminate\Http\Request object
     * revoke and delete the granted token to the user effectively logging out the user
     * @return json object with success message
     */
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $token->delete();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function updateAccount(Request $request) {
        $user = Auth::user();
        $customMessage = [
            'password.regex' => 'The password must containt at least one lowercase, one uppercase, one digit, and one special character.'
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore($user)
            ],
            'phone' => [
                'required', 'string',
                Rule::unique('users')->ignore($user)
            ],
            'woreda' => 'required|integer|min:1|max:30',
            'password' => [
                'nullable', 'string','min:8','confirmed',
                'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/',
                function ($attribute, $value, $fail) {
                    if (Hash::check($value, Auth::user()->password)) {
                        $fail('The password has not changed.');
                    }
                },
            ],
            'old_password' => [
                'required', 'string',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Old Password didn\'t match.');
                    }
                },
            ],
        ], $customMessage);
        if ($validator->fails()) {
            return response([
                'errors'=>$validator->errors()->messages(),
                'message' => 'The given data was invalid!',
                'pass' => Auth::user()->password
            ], 422);
        }
        if($request->has('password') && $request['password'] != "")
            $user->password = Hash::make($request['password']);
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->woreda = $request['woreda'];
        $user->save();
        $response = ['success' => true, 'message' => 'You have successfully updated your account.', 'user' => Auth::user()];
        return response($response, 200);
    }
}
