<?php

namespace App\Http\Controllers\Controladores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Rol;

class controllerroles extends Controller
{
    public function index(Request $request)
    {          
           // Log::channel('slack')->info('Algo esta sucediendo en Estados',[$request]);
            return response()->json([
                "status"=>200,
                "data"=>Rol::all()
            ]);
    }

    public function create(Request $request)
    {
        
        // Log::channel('slack')->info('Algo esta sucediendo en Estados',[$request]);
        $validacion=Validator::make
        (
            $request->all(),
            [
                "nombre"=>"required|min:3|max:50",     
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido"
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $rol= new Rol();
        $rol->nombre=$request->nombre;
        

        if($rol->save())
        return response()->json([
            "status"=>200,
            "message"=>"datos almacenados",
            "error"=>[],
            "data"=>$request->all()
        ]);



        
    }
}
