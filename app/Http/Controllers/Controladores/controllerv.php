<?php

namespace App\Http\Controllers\Controladores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Paqueteria\Vehiculo;
use Illuminate\Support\Facades\Http;

class controllerv extends Controller
{

    //VER
    public function index(Request $request)
    {
      //  Log::channel('slack')->info('Algo esta sucediendo',[$request]);

        
        return response()->json([
            "status"=>200,
            "data"=>Vehiculo::all()
        ]);
    }

    public function create(Request $request)
    {
         Log::channel('slack')->info('Algo esta sucediendo',[$request]);

        $validacion=Validator::make(
            $request->all(),
            [
                "modelo"=>"required|min:3|max:20",
                "marca"=>"required|min:3|max:20",
                "año"=>"required|date",
                "color"=>"required|min:3|max:20",
                "placas"=>"required|size:7",     
            ],
            [
                "modelo.required"=>"el campo :attribute es requerido",
                "marca.required"=>"el campo :attribute es requerido",
                "año.required"=>"el campo :attribute es requerido",
                "color.required"=>"el campo :attribute es requerido",
                "placas.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        
    
        $vehiculo= new Vehiculo();

        $vehiculo->modelo=$request->modelo;
        $vehiculo->marca=$request->marca;
        $vehiculo->año=$request->año;
        $vehiculo->color=$request->color;
        $vehiculo->placas=$request->placas;

        if($vehiculo->save())
        return response()->json([
            "status"=>200,
            "message"=>"datos almacenados",
            "error"=>[],
            "data"=>$request->all()
        ]);

        
        
    }

    public function update(Request $request,int $id)
    {
        Log::channel('slack')->info('Algo esta sucediendo',[$request]);

        $validacion=Validator::make
        (
        $request->all(),
        [
            "modelo"=>"required|min:3|max:20",
            "marca"=>"required|min:3|max:20",
            "año"=>"required|date",
            "color"=>"required|min:3|max:20",
            "placas"=>"required|size:7",     
        ],
        [
            "modelo.required"=>"el campo :attribute es requerido",
            "marca.required"=>"el campo :attribute es requerido",
            "año.required"=>"el campo :attribute es requerido",
            "color.required"=>"el campo :attribute es requerido",
            "placas.required"=>"el campo :attribute es requerido",
        ]
     );
        if($validacion->fails())
     return response()->json([
        "status"=>400,
        "message"=>"Error en los datos",
        "error"=> $validacion->errors(),
        "data"=>[]
        ],400);
        
     
        $vehiculo =Vehiculo::find($id);
        
        if($vehiculo)
        {
            $vehiculo->modelo=$request->modelo;
            $vehiculo->marca=$request->marca;
            $vehiculo->año=$request->año;
            $vehiculo->color=$request->color;
            $vehiculo->placas=$request->placas;
        if($vehiculo->save())
        return response()->json([
            "status"=>200,
            "message"=>"datos almacenados",
            "error"=>[],
            "data"=>$request->all()
        ]);
        else
     {
        return response()->json([
            "status"=>400,
            "message"=>"datos no encontrados",
            "error"=>[],
            "data"=>$request->all()]);
     }
    }
    }

    
}
