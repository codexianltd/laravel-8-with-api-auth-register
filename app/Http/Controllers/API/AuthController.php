<?php

namespace App\Http\Controllers\API;

use App\Acl;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthUserResource;
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

		$user->assignRole(Acl::ROLE_USER);

		$accessToken = $user->createToken('authToken');

		return response(['user' => new AuthUserResource($user), 'access_token' => $accessToken->plainTextToken]);
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

		return response(['user' => AuthUserResource(auth()->user()), 'access_token' => $accessToken]);
	}
	public function me(Request $request)
	{
		return response(['user' => new AuthUserResource(auth()->user())]);
	}
}