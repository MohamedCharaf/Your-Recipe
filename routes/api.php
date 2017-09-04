<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'AuthController@register');
// Route::post('/register',function () {
// 	return response()->json([
// 		'data' => request()->all()
// 	], 200);
// });
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

Route::resource('recipes', 'RecipeController');
