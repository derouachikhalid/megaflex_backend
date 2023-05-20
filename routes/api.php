<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\MachineController;
use App\Http\Controllers\API\InterController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PieceController;
use App\Http\Controllers\FournissorController;

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
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::group(['middleware' => ['auth:sanctum','isApiAdmin']], function(){

    Route::get('/checkingAuth',function (){
        return response()->json(['message'=>'you are in','status'=>200]);
    });

    //fournisseurs
    Route::post('add-fournissor',[FournissorController::class,'addFournissor']);
    Route::get('viewfournissors',[FournissorController::class,'index']);
    Route::get('editfournisseur/{id}',[FournissorController::class,'editFournissor']);
    Route::post('updatefournisseur/{id}',[FournissorController::class,'editAFournissor']);
    Route::delete('deleteFour/{id}',[FournissorController::class,'deleteFournissor']);

    //machines
    Route::post('add-machine',[MachineController::class,'addMachine']);
    
    Route::get('editmachine/{ref}',[MachineController::class,'selectMachine']);
    
    Route::get('machine/number',[MachineController::class,'getMachineNumber']);
    Route::post('updatemachine/{ref}',[MachineController::class,'editMachine']);
    Route::delete('deletemachine/{ref}',[MachineController::class,'deleteMachine']);
    Route::post('changeStatus/{ref}',[MachineController::class,'changeStatus']);
    
    

    //clients
    Route::post('add-client',[ClientController::class,'addClient']);
    Route::get('viewclients',[ClientController::class,'index']);
    Route::get('selectclient/{id}',[ClientController::class,'selectClient']);
    Route::post('editclient/{id}',[ClientController::class,'editClient']);
    Route::delete('deleteclient/{id}',[ClientController::class,'deleteClient']);

    //pieces
    Route::post('add-piece',[PieceController::class,'addPiece']);
    
    Route::get('selectpiece/{sn}',[PieceController::class,'selectPiece']);
    Route::post('editpiece/{sn}',[PieceController::class,'editPiece']);
    Route::delete('deletepiece/{SN}',[PieceController::class,'deletePiece']);

    

    //users
    
    
    Route::get('viewingenieurs',[UserController::class,'getEngineer']);
    Route::get('ingenieur/number',[UserController::class,'getEngineerNumber']);


    

});
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/checkUseringAuth',function (){
        return response()->json(['message'=>'you are in','status'=>200]);
    });
    //interventions
    Route::get('viewinterventions',[InterController::class,'index']);
    Route::post('addintervention',[InterController::class,'addIntervention']);
    Route::post('updateintervention/{code}',[InterController::class,'editIntervention']);
    Route::get('viewintervention/{code}',[InterController::class,'viewInter']);
    



    Route::get('viewpieces',[PieceController::class,'index']);

    Route::get('viewusers',[UserController::class,'index']);

    
    Route::delete('deleteintervention/{ref}',[InterController::class,'deleteInter']);

    Route::get('getuserauth',[AuthController::class,'getUser']);
    Route::get('viewmachines',[MachineController::class,'index']);
    Route::get('viewmachine/{ref}',[MachineController::class,'getMachineInfo']);
    
    
    Route::post('logout',[AuthController::class,'logout']);
    
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    
});

