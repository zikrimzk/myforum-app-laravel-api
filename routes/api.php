<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Post\PostingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/testapi',function(){
    return response([
        'message' => 'Api is working'
    ],200 );
});

//Register & Login API
Route::post('/register',[AuthenticationController::class, 'register']);
Route::post('/login',[AuthenticationController::class, 'login']);

//Posting API
Route::post('/insertpost',[PostingController::class, 'insert'])->middleware('auth:sanctum');
Route::post('/likepost-{id}',[PostingController::class, 'likePost'])->middleware('auth:sanctum');
Route::get('/showpost',[PostingController::class, 'showPost'])->middleware('auth:sanctum');
Route::post('/commentpost-{id}',[PostingController::class, 'commentPost'])->middleware('auth:sanctum');
Route::get('/getcomment-{id}',[PostingController::class, 'getComment'])->middleware('auth:sanctum');





