<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
	public function authenticate(Request $request)
	{
    $credentials = $request->only('username', 'password');
		try {
			if (!Auth::attempt($credentials)) {
				throw ValidationException::withMessages([
					'username' => ['Invalid credentials'],
				]);
			}

			$user = Auth::user();
			$token = JWTAuth::fromUser($user);

			return response()->json([
				"meta" => [
					'success' => true,
					'errors' => []
				],
				"data" => [
					"token"=> $token,
					"minutes_to_expire" => JWTAuth::factory()->getTTL()
				]
			]);
		} catch (\Exception $e) {
			return response()->json([
				"meta" => [
					'success' => false,
					'errors' => "Password incorrect for: {$request->username}"
				],
			], 401);
		}
  }
}
