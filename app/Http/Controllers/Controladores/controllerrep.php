<?php

namespace App\Http\Controllers\Controladores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Paqueteria\Repartidor;
use Illuminate\Support\Facades\Http;

class controllerrep extends Controller
{

        //VER
        public function index(Request $request)
        {
            
      //  Log::channel('slack')->info('Algo esta sucediendo en Repartidores',[$request]);

            return response()->json([
                "status"=>200,
                "data"=>Repartidor::all()
            ]);
        }

    public function create(Request $request)
    {
              // Log::channel('slack')->info('Algo esta sucediendo en Repartidores',[$request]);

              $validacion=Validator::make(
                $request->all(),
                [
                    "nombre"=>"required|min:3|max:50",
                    "correo"=>"required|min:3|max:50|email",
                    "telefono"=>"required|integer",
                    "no_licencia"=>"required|integer|digits:14",     
                ],
                [
                    "nombre.required"=>"el campo :attribute es requerido",
                    "correo.required"=>"el campo :attribute es requerido",
                    "telefono.required"=>"el campo :attribute es requerido",
                    "no_licencia.required"=>"el campo :attribute es requerido",
                ]
            );
            if($validacion->fails())
            return response()->json([
                "status"=>400,
                "message"=>"Error en los datos",
                "error"=> $validacion->errors(),
                "data"=>[]
            ],400);
    
    
    
            $repartidor= new Repartidor();
    
            $repartidor->nombre=$request->nombre;
            $repartidor->correo=$request->correo;
            $repartidor->telefono=$request->telefono;
            $repartidor->no_licencia=$request->no_licencia;
    
            return response()->json([
                "status"=>200,
                "message"=>"datos almacenados",
                "error"=>[],
                "data"=>$request->all()
            ]);
    
            

        
    }

    public function k(Request $request)
    {

    }

    public function update(Request $request,int $id)
    {
        Log::channel('slack')->info('Algo esta sucediendo en Repartidores',[$request]);

        $validacion=Validator::make(
            $request->all(),
            [
                "nombre"=>"required|min:3|max:50",
                "correo"=>"required|min:3|max:50|email",
                "telefono"=>"required|integer",
                "no_licencia"=>"required|integer|digits:14",     
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "correo.required"=>"el campo :attribute es requerido",
                "telefono.required"=>"el campo :attribute es requerido",
                "no_licencia.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $repartidor =Repartidor::find($id);
      
        if($repartidor)
        {
            
            $repartidor->nombre=$request->nombre;
            $repartidor->correo=$request->correo;
            $repartidor->telefono=$request->telefono;
            $repartidor->no_licencia=$request->no_licencia;
            if($repartidor->save())
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
