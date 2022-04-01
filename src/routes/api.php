<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Client\ClientController;
use \App\Http\Controllers\Image\ImageController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Post('/images/getall', [ImageController::class, 'getImages']);
Route::Post('/images/delete', [ImageController::class, 'delete']);

Route::Get('/client/products/getall', [ClientController::class, 'getAllProducts'])->middleware('auth');
