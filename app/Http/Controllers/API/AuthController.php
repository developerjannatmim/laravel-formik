<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email|max:191',
      'password' => 'required|min:6',
    ]);
    if ($validation->fails()) {
      return response()->json([
        'validation_error' => $validation->errors()->first(),
      ]);
    } else {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ]);
      $token = $user->createToken($user->email . '_Token')->plainTextToken;
      return response()->json([
        'status' => 200,
        'user_name' => $user->name,
        'token' => $token,
        'message' => 'Register successful.',
      ]);
    }
  }

  public function login(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'email' => 'required|email|max:191',
      'password' => 'required|min:6',
    ]);
    if ($validation->fails()) {
      return response()->json([
        'validation_errors' => $validation->errors(),
      ]);
    } else {
      $user = User::where('email', $request->email)->first();
      if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
          'status' => 401,
          'errors' => 'Wrong Credentials',
        ]);
      } else {
        $token = $user->createToken($user->email . '_Token')->plainTextToken;
        return response()->json([
          'status' => 200,
          'name' => $user->name,
          'token' => $token,
          'message' => 'LoggedIn Successful.',
        ]);
      }
    }
  }

}
