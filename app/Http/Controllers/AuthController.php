<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
  public function login(Request $request)
  {
    $credentials = $request->only('username', 'password');

    if (!$token = JWTAuth::attempt($credentials)) {
      return $this->sendError('Unauthorised.', ['error' => 'Invalid credentials']);
    }

    return $this->respondWithToken($token);
  }

  public function register(UserRequest $request)
  {
    $input = $request->validated();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $user->assignRole('admin');

    return $this->sendSuccess($user, 'User registered successfully');
  }

  // Get the authenticated User
  public function profile()
  {
    return $this->sendSuccess(Auth::user(), 'User data successfully retrieved');
  }

  // Log the user out (Invalidate the token)
  public function logout()
  {
    //auth expires token
    JWTAuth::invalidate(JWTAuth::getToken());
    Auth::logout();
    return $this->sendSuccess(null, 'Successfully logged out');
  }

  // Custom response with token
  protected function respondWithToken($token)
  {
    return response()->json([
      'code' => 200,
      'access_token' => $token,
      'token_type' => 'bearer',
      'user' => [
        'id' => Auth::user()->id,
        'username' => Auth::user()->username,
        'email' => Auth::user()->email,
        'name' => Auth::user()->name,
      ],
      'roles' => Auth::user()->roles->first()->name,
    ]);
  }
}
