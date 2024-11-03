<?php

namespace App\Http\Controllers\Auth;

// use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthenticationController extends Controller
{

    //Register function 
    public function register(RegisterRequest $req)
    {
        $req->validated();

        $userData = [
            'name' => $req->name,
            'username' => $req->username,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ];

        $user = User::create($userData);
        $token = $user->createToken('myforum')->plainTextToken;

        return response([
            'user'=> $user,
            'token'=>$token
        ],201);

    }

    //Login function
    public function login(LoginRequest $req)
    {
        $req->validated();
        $credential = User::whereUsername($req->username)->first();

        if(!$credential || !Hash::check($req->password ,$credential->password))
        {
            return response([
                'message' => 'Invalid credentials !'
            ],422);
        }

        $token = $credential->createToken('myforum')->plainTextToken;

        return response([
            'user'=> $credential,
            'token'=>$token
        ],200);

    }
}
