<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MoovMoneyController;

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

Route::get('/example', function () {
    return response()->json(['message' => 'Hello, world!']);
});

 



Route::post('moovcollection', [MoovMoneyController::class, 'moovCollection']);
Route::post('moovtransfer', [MoovMoneyController::class, 'floozTransfer']);
 
//Route::post('register', [MoovMoneyController::class, 'showStatusCodeError']);
Route::post('moovpushwithpending', [MoovMoneyController::class, 'moovPushWithPending']);
Route::post('moovcashintransaction', [MoovMoneyController::class, 'moovCashInTransaction']);

Route::post('moovairtimetransaction', [MoovMoneyController::class, 'moovAirTimeTransaction']);
Route::post('moovtransactionstatus', [MoovMoneyController::class, 'getMoovCollectionStatus']);
Route::post('moovgetbalance', [MoovMoneyController::class, 'moovGetBalance']);
Route::post('moovmobilestatus', [MoovMoneyController::class, 'moovGetMobileStatus']);
