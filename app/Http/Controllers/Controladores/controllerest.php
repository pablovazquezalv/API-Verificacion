<?php

namespace App\Http\Controllers\Controladores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Paqueteria\Estado;
use Illuminate\Support\Facades\Http;

class controllerest extends Controller
{
        //VER

           

        public function index(Request $request)
        {          
           // Log::channel('slack')->info('Algo esta sucediendo en Estados',[$request]);
            return response()->json([
                "status"=>200,
                "data"=>Estado::all()
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
                "region"=>"required|min:3|max:50",     
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "region.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $estado= new Estado();
        $estado->nombre=$request->nombre;
        $estado->region=$request->region;

        if($estado->save())
        return response()->json([
            "status"=>200,
            "message"=>"datos almacenados",
            "error"=>[],
            "data"=>$request->all()
        ]);



        
    }


    public function createEstadoSinHttp(Request $request)
    {
        
      
    }


    public function update(Request $request,int $id)
    {
        Log::channel('slack')->info('Algo esta sucediendo en Estados',[$request]);

              $validacion=Validator::make(
            $request->all(),
            [
                "nombre"=>"required|min:3|max:50",
                "region"=>"required|min:3|max:50",     
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "region.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $estado =Estado::find($id);
      
      
        if($estado)
        {
            
            $estado->nombre=$request->nombre;
            $estado->region=$request->region;
            if($estado->save())
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
