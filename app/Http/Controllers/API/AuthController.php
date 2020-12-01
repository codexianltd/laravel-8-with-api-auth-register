<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function register(Request $request)
	{
		$validatedData = $request->validate([
			'name' => 'required|max:55',
			'email' => 'email|required|unique:users',
			'password' => 'required|confirmed',
		]);

		$validatedData['password'] = bcrypt($request->password);

		$user = User::create($validatedData);

		$accessToken = $user->createToken('authToken');

		return response(['user' => $user, 'access_token' => $accessToken->plainTextToken]);
	}

	public function login(Request $request)
	{
		$loginData = $request->validate([
			'email' => 'email|required',
			'password' => 'required',
		]);

		if (!auth()->attempt($loginData))
		{
			return response(['message' => 'Invalid Credentials']);
		}

		$accessToken = auth()->user()->createToken('authToken')->plainTextToken;

		return response(['user' => auth()->user(), 'access_token' => $accessToken]);
	}
	public function me(Request $request)
	{
		return response(['user' => auth()->user()]);
	}
}