<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;


class AuthController extends Controller
{
	function __construct()
	{
		$this->middleware('auth:api')
			->only('logout');
	}

	public function register(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|max:255',
			'email' => 'required|email|unique:users',
			'password' => 'required:between:6,25:|confirmed'
		]);

		User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
		]);

		return response()->json([
			'registered' => 'true'
		], 201);
	}

	public function login(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required'
		]);

		$user = User::where('email', $request->email)
			->first();

		if ($user && Hash::check($request->password, $user->password)) {
			$user->api_token = str_random(60);
			$user->save();

			return response()->json([
				'authenticated' => true,
				'api_token' => $user->api_token,
				'user_id' => $user->id
			]);
		}

		return response()->json([
			'message' => 'provideed email and password do not match'
		], 422);
	}

	public function logout(Request $request)
	{
		$user = $request->user();
		$user->api_token = null;
		$user->save();

		return response()->json([
				'logged_out' => true
		], 200);	
	}

}
