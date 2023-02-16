<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controladores\controllerv;
use App\Http\Controllers\Controladores\controllerrep;
use App\Http\Controllers\Controladores\controllerest;
use App\Http\Controllers\Controladores\controllerciudad;
use App\Http\Controllers\Controladores\controllercolonia;
use App\Http\Controllers\Controladores\controllerpaquete;
use App\Http\Controllers\Controladores\controllerrepvehpaq;
use App\Http\Controllers\Controladores\Libreria\controllerEditorial;
use App\Http\Controllers\Controladores\Libreria\controllerExistencias;
use App\Http\Controllers\Controladores\Libreria\controllerLibro;
use App\Http\Controllers\Controladores\Libreria\controllerSucursal;
use App\Http\Controllers\Controladores\controllerroles;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\AuthController;





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

//LOGIN
Route::prefix('/v1/login')->group(function()
{   
    Route::post("/register",[AuthController::class,"register"]);
    Route::post("/sendsms",[AuthController::class,"smsenviar"]);
    Route::post("/login",[AuthController::class,"login"]);
    Route::post("/logout",[AuthController::class,"logout"])->middleware('auth:sanctum');
    Route::post('/verifynumber', [AuthController::class,'verifyNumber']); 
    Route::get('/verify',[AuthController::class,'confirm']);
});

Route::prefix('/v1/cola')->group( function(){   
    Route::post("/cola1",[JobsController::class,
    "job"]);
});

Route::get('/verify',[AuthController::class,'verified'])->name('verify');

//VEHICULOS
Route::middleware(['auth:sanctum'])->prefix('/v1/vehiculos')
->group
(function()
{   //POST middleware( ) 
    Route::post("/create",[controllerv::class,
    "create"])->middleware(['Roles:1,3']);
    Route::get("/index",[controllerv::class,
    "index"])->middleware(['Roles:1,2,3']);
    Route::put("/update/{id}",[controllerv::class,
    "update"])->where(['id'=>'[0-9]+']);
});

//REPARTIDORES
Route::middleware(['auth:sanctum','RolUser:1'])
->prefix('/v1/repartidores')
->group
(function()
{   //POST  
    Route::post("/create",[controllerrep::class,
    "create"]);
    Route::get("/index",[controllerrep::class,
    "index"]);
    Route::put("/update/{id}",[controllerrep::class,
    "update"]);
});


//ESTADOS
Route::middleware(['auth:sanctum','RolUser:1'])
->prefix('/v1/estados')->group
(function()
{   //POST  
    Route::post("/create",[controllerest::class,
    "create"])->middleware('auth:sanctum');
    Route::get("/index",[controllerest::class,
    "index"])->middleware('auth:sanctum');
    Route::put("/update/{id}",[controllerest::class,
    "update"])->where(['id'=>'[0-9]+'])->middleware('auth:sanctum');
});

//CIUDADES
Route::middleware(['auth:sanctum','RolUser:1'])
->middleware( 'rol.user' )
->prefix('/v1/ciudades')->group
(function()
{   //POST  
    Route::post("/create",[controllerciudad::class,
    "create"]);
    Route::get("/index",[controllerciudad::class,
    "index"]);

    Route::get("/consultaJoin",[controllerciudad::class,
    "consultaJoin"])->middleware('auth:sanctum');

    Route::get("/indexV2",[controllerciudad::class,
    "indexV2"])->middleware('auth:sanctum');



    Route::put("/update/{id}",[controllerciudad::class,
    "update"])->where(['id'=>'[0-9]+']);  
});

//CIUDADES
Route::middleware(['auth:sanctum','RolUser:1'])
->middleware('rol.user')
->prefix('/v1/colonias')->group
(function()
{   //POST  
    Route::post("/create",[controllercolonia::class,
    "create"]);
    Route::get("/index",[controllercolonia::class,
    "index"]);
    Route::put("/update/{id}",[controllercolonia::class,
    "update"])->where(['id'=>'[0-9]+']);
});


//PAQUETES
Route::middleware(['auth:sanctum','RolUser:1'])
->prefix('/v1/paquetes')->group
(function()
{   //POST  
    Route::post("/create",[controllerpaquete::class,
    "create"]);
    Route::get("/index",[controllerpaquete::class,
    "index"]);
    Route::put("/update/{id}",[controllerpaquete::class,
    "update"]);
});


//ENVIOS
Route::middleware(['auth:sanctum','RolUser:1'])
->prefix('/v1/envio')->group
(function()
{   //POST  
    Route::post("/create",[controllerrepvehpaq::class,
    "create"]);
    Route::get("/index",[controllerrepvehpaq::class,
    "index"]);
    Route::put("/update/{id}",[controllerrepvehpaq::class,
    "update"])->where(['id'=>'[0-9]+']);
});

//ROLES
Route::prefix('/v1/rol')->group
(function()
{     
    Route::get("/index",[controllerroles::class,
    "index"]);
    Route::post("/create",[controllerroles::class,
    "create"]);
    Route::put("/update/{id}",[controllerroles::class,
    "update"])->where(['id'=>'[0-9]+']);
});


//RUTAS ISRAELBD
Route::middleware(['auth:sanctum','RolUser:1'])
->prefix("/v2")->group
(function()
{
    Route::prefix("/editorial")
    ->group(function()
    {
        Route::post("/create",[ControllerEditorial::class,
        "create"]);
        Route::get("/index",[ControllerEditorial::class,
        "index"]);
        Route::put("/update/{id}",[ControllerEditorial::class,
        "update"])->where(['id'=>'[0-9]+']);
    });
    Route::prefix("/Existencia")->group(function(){
        Route::post("/create",[ControllerExistencia::class,
        "create"]);
        Route::get("/index",[ControllerExistencia::class,
        "index"]);
        Route::put("/update/{id}",[ControllerExistencia::class,
        "update"])->where(['id'=>'[0-9]+']);
    });
    Route::prefix("/libro")->group(function(){
        Route::post("/create",[ControllerLibro::class,
        "create"]);
        Route::get("/index",[ControllerLibro::class,
        "index"]);
        Route::put("/update/{id}",[ControllerLibro::class,
        "update"])->where(['id'=>'[0-9]+']);
    });
    Route::prefix("/sucursal")->group(function(){
        Route::post("/create",[ControllerSucursal::class,
        "create"]);
        Route::get("/index",[ControllerSucursal::class,
        "index"]);
        Route::put("/update/{id}",[ControllerSucursal::class,
        "update"])->where(['id'=>'[0-9]+']);
    });
});