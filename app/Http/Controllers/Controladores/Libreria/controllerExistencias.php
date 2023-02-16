<?php

namespace App\Http\Controllers\Controladores\Libreria;

use App\Http\Controllers\Controller;
use App\Models\libreria\existencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class controllerExistencias extends Controller
{
    public function index(Request $request)
    {
        
        //Log::channel('slack')->info('Algo esta sucediendo en Editoriales',[$request]);

        return response()->json([
            "status"=>200,
            "data"=>existencia::all()
        ]);
    }

    //CREAR
    public function create(Request $request)
    {
      //  Log::channel('slack')->info('Algo esta sucediendo en Editoriales',[$request]);

            $validacion=Validator::make(
            $request->all(),
            [
                "nombre"=>"required|min:3|max:50",
                "libro"=>"required|integer",     
                "sucursal"=>"required|integer",     
                "existencia"=>"required|integer",         
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "libro.required"=>"el campo :attribute es requerido",
                "sucursal.required"=>"el campo :attribute es requerido",
                "existencia.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $response = http::withToken($request->bearerToken())->post(env('IP_TEMP')+'api/v1/Existencias/create',
        [
       "nombre"=>$request->nombre,
       "libro"=>$request->libro,
       "sucursal"=>$request->sucursal,
       "existencia"=>$request->existencia
        ]);

        if($response->successful())
        {
            $existencia=new existencia();

            $existencia->nombre=$request->nombre;
            $existencia->libro=$request->libro;
            $existencia->sucursal=$request->sucursal;
            $existencia->existencia=$request->existencia;
            
            if($existencia->save())
            return response()->json([
                "status"=>$response->status(),
                "message"=>"datos almacenados",
                "error"=>[],
                "data"=>$request->all()
            ]);
        }
    }



    public function update(Request $request,int $id)
    {
        Log::channel('slack')->info('Algo esta sucediendo en Ciudades',[$request]);

        $validacion=Validator::make(
            $request->all(),
            [
                "nombre"=>"required|min:3|max:50",
                "libro"=>"required|integer",     
                "sucursal"=>"required|integer",     
                "existencia"=>"required|integer",         
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "libro.required"=>"el campo :attribute es requerido",
                "sucursal.required"=>"el campo :attribute es requerido",
                "existencia.required"=>"el campo :attribute es requerido",
            ]
        );
     if($validacion->fails())
     return response()->json([
        "status"=>400,
        "message"=>"Error en los datos",
        "error"=> $validacion->errors(),
        "data"=>[]
        ],400);

        $response = http::post('ip',
        [
       "nombre"=>$request->nombre,
       "libro"=>$request->libro,
       "sucursal"=>$request->sucursal,
       "existencia"=>$request->existencia
        ]);

        $existencia =existencia::find($id);
        
        if($existencia)
        {
            
            $existencia->nombre=$request->nombre;
            $existencia->libro=$request->libro;
            $existencia->sucursal=$request->sucursal;
            $existencia->existencia=$request->existencia;
        
        }

        if($existencia->save())
        return response()->json([
            "status"=>$response->status(),
            "message"=>"datos almacenados",
            "error"=>[],
            "data"=>$request->all()
        ]);
    }
}
