<?php

namespace App\Http\Controllers\Controladores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Paqueteria\Colonia;
use Illuminate\Support\Facades\Http;

class controllercolonia extends Controller
{

        //VER
        public function index(Request $request)
        {
            return response()->json([
                "status"=>200,
                "data"=>Colonia::all()
            ]);
        }


    public function create(Request $request)
    {
       
            $validacion=Validator::make(
                $request->all(),
                [
                    "nombre"=>"required|min:3|max:40",
                    "codigo_postal"=>"required|min:3|max:10",
                    "ciudad_id"=>"required|max:50",     
                ],
                [
                    "nombre.required"=>"el campo :attribute es requerido",
                    "codigo_postal.required"=>"el campo :attribute es requerido",
                    "ciudad_id.required"=>"el campo :attribute es requerido",
                    
                ]
            );
            if($validacion->fails())
            return response()->json([
                "status"=>400,
                "message"=>"Error en los datos",
                "error"=> $validacion->errors(),
                "data"=>[]
            ],400);
    
            $colonia= new Colonia();
    
            $colonia->nombre=$request->nombre;
            $colonia->codigo_postal=$request->codigo_postal;
            $colonia->ciudad_id=$request->ciudad_id;
            
            if($colonia->save())        
            return response()->json([
                "status"=>200,
                "message"=>"datos almacenados",
                "error"=>[],
                "data"=>$request->all()
            ]);
    

        
    }


    

    public function update(Request $request,int $id)
    {
        Log::channel('slack')->info('Algo esta sucediendo en Colonias',[$request]);

             $validacion=Validator::make(
            $request->all(),
            [
                "nombre"=>"required|min:3|max:40",
                "codigo_postal"=>"required|min:3|max:10",
                "ciudad_id"=>"required|max:50",     
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "codigo_postal.required"=>"el campo :attribute es requerido",
                "ciudad_id.required"=>"el campo :attribute es requerido",
                
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);
   

        $colonia =Colonia::find($id);
  
        if($colonia)
        {

            $colonia->nombre=$request->nombre;
            $colonia->codigo_postal=$request->codigo_postal;
            $colonia->ciudad_id=$request->ciudad_id;
            if($colonia->save())
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
