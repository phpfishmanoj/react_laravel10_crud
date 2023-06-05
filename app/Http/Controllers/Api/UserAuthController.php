<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAuthController extends Controller
{
    //
    public function signup(SignupRequest $request)
    {
        $data = $request->validated();
        /** @var \User\Models\User $user  */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['name']),
        ]);
        $token = $user->createToken('main')->plainTextToken;
        //return response(['user' => $user, 'token' => $token]);
        return response(compact('user', 'token'));
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Email or Password is incorrect',
            ], 422);
        }
        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'));
    }
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $request->user()->currentAccessToken()->delete();
        return response('', 204);
    }
}
