<?php

use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;

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

//for login and register

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

//main end point
Route::middleware('auth:sanctum')->group(function(){

    //transaction
    Route::get('show',[Admincontroller::class,'show']);
    Route::post('create',[Admincontroller::class,'create']);
    Route::put('edit',[Admincontroller::class,'edit']);
    Route::delete('delete',[Admincontroller::class,'delete']);

    //record
    Route::get('showrecords/{id}',[Admincontroller::class,'records_show']);
    Route::post('createrecords',[Admincontroller::class,'records_create']);
    Route::put('editrecords/{id}',[Admincontroller::class,'records_edit']);
    Route::delete('deleterecords/{id}',[Admincontroller::class,'records_delete']);

    //for report
    Route::post('generateReport',[ReportController::class,'generateReport']);
    Route::get('showrecord',[ReportController::class,'showrecord']);

});
