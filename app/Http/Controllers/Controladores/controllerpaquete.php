<?php

namespace App\Http\Controllers\Controladores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Paqueteria\Paquete;
use Illuminate\Support\Facades\Http;

class controllerpaquete extends Controller
{


        //VER
        public function index(Request $request)
        {
            
      //   Log::channel('slack')->info('Algo esta sucediendo en Paquetes',[$request]);

            return response()->json([
                "status"=>200,
                "data"=>Paquete::all()
            ]);
        }


    public function create(Request $request)
    {
        // Log::channel('slack')->info('Algo esta sucediendo en Paquetes',[$request]);

        $validacion=Validator::make(
            $request->all(),
            [
                "descripcion"=>"required|min:3|max:50",
                "remitente"=>"required|min:3|max:50",
                "tamaño"=>"required",
                "peso"=>"required",
                "dirreccion"=>"required",   
                "colonia_id"=>"required|integer",   
                
            ],
            [
                "descripcion.required"=>"el campo :attribute es requerido",
                "remitente.required"=>"el campo :attribute es requerido",
                "tamaño.required"=>"el campo :attribute es requerido",
                "peso.required"=>"el campo :attribute es requerido",
                "dirreccion.required"=>"el campo :attribute es requerido",
                "colonia_id.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);


        $paquete= new Paquete();

        $paquete->descripcion=$request->descripcion;
        $paquete->remitente=$request->remitente;
        $paquete->tamaño=$request->tamaño;
        $paquete->peso=$request->peso;
        $paquete->dirreccion=$request->dirreccion;
        $paquete->colonia_id=$request->colonia_id;
        if($paquete->save())
        return response()->json([
            "status"=>200,
            "message"=>"datos almacenados",
            "error"=>[],
            "data"=>$request->all()
        ]);

        
    }


    public function update(Request $request,int $id)
    {
        Log::channel('slack')->info('Algo esta sucediendo en Paquetes',[$request]);

        $validacion=Validator::make(
        $request->all(),
        [
            "descripcion"=>"required|min:3|max:50",
            "remitente"=>"required|min:3|max:50",
            "tamaño"=>"required",
            "peso"=>"required",
            "dirreccion"=>"required",   
            "colonia_id"=>"required|integer",   
            
        ],
        [
            "descripcion.required"=>"el campo :attribute es requerido",
            "remitente.required"=>"el campo :attribute es requerido",
            "tamaño.required"=>"el campo :attribute es requerido",
            "peso.required"=>"el campo :attribute es requerido",
            "dirreccion.required"=>"el campo :attribute es requerido",
            "colonia_id.required"=>"el campo :attribute es requerido",
        ]
     );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $paquete =Paquete::find($id);
      
        if($paquete)
        {
            
            $paquete->descripcion=$request->descripcion;
            $paquete->remitente=$request->remitente;
            $paquete->tamaño=$request->tamaño;
            $paquete->peso=$request->peso;
            $paquete->dirreccion=$request->dirreccion;
            $paquete->colonia_id=$request->colonia_id;
            if($paquete->save())
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
