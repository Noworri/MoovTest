
<?php

 
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\MoovController; 

// use this in localc
// header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Methods: DELETE, GET, POST, OPTIONS, PUT');
// header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
// header('Access-Control-Allow-Credentials: true');

// header("Access-Control-Allow-Headers: Content-Type, Accept");
// header("Access-Control-Allow-Headers: *");
// header("Access-Control-Allow-Origin: *");
// header('content-type: application/json; charset=utf-8');
// header('Access-Control-Allow-Methods','DELETE,GET,POST,OPTIONS,PUT');


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
 
Route::post('moovcollection', [MoovController::class, 'moovCollection']);
Route::post('moovtransactionstatus', [MoovController::class, 'getMoovCollectionStatus']);
Route::post('moovtransfer', [MoovController::class, 'moovTransfer']);
Route::post('moovmobilestatus', [MoovController::class, 'moovGetMobileStatus']);
Route::post('moovcashintransaction', [MoovController::class, 'moovCashInTransaction']);
Route::post('moovairtimetransaction', [MoovController::class, 'moovAirTimeTransaction']);
Route::post('moovpushwithpending', [MoovController::class, 'moovPushWithPending']);
Route::post('moovgetbalance', [MoovController::class, 'moovGetBalance']);


 