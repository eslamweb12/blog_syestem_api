<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\service\message;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function register(UserRequest $request){
        $data = $request->validated();
         $data['password'] = bcrypt($data['password']);
        $user =User::query()->create($data);
        $token = JWTAuth::fromUser($user);
       return  message::success($user, $token,'user created successfully');



    }


    public function login(UserRequest $request){
        $credentials = $request->only('email', 'password');
        if(!$token=JWTAuth::attempt($credentials)){
            return  message::error('email or password is incorrect',401);
        }
        return  message::success('',$token,'user login successfully');



    }


}
