<?php

namespace App\Http\Controllers\Controladores\Libreria;

use App\Http\Controllers\Controller;
use App\Models\libreria\editorial;
use App\Models\libreria\sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class controllerEditorial extends Controller
{

    //VER EDITORIALES
    public function index(Request $request)
    {
        // Log::channel('slack')->info('Algo esta sucediendo en Editoriales',[$request]);
        return response()->json([
            "status"=>200,
            "data"=>editorial::all()
        ]);
    }

    //CREAR
    public function create(Request $request)
    {
        //Log::channel('slack')->info('Algo esta sucediendo en Editoriales',[$request]);

            $validacion=Validator::make(
            $request->all(),
            [
                "nombre"=>"required|min:3|max:50",
                "direccion"=>"required|max:100",     
                "ciudad"=>"required|max:30",     
                "telefono"=>"required|max:10",     
                "correo"=>"required|max:60",     
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "direccion.required"=>"el campo :attribute es requerido",
                "ciudad.required"=>"el campo :attribute es requerido",
                "telefono.required"=>"el campo :attribute es requerido",
                "correo.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

            $response = http::post(env('IP_TEMP')+'api/v1/Editorial/create',
            [
                "nombre"=>$request->nombre,
                "direccion"=>$request->direccion,
                "ciudad"=>$request->ciudad,
                "telefono"=>$request->telefono,
                "correo"=>$request->correo,
            ]);

        if($response->successful())
        {
            $editorial=new editorial();

            $editorial->nombre=$request->nombre;
            $editorial->direccion=$request->direccion;
            $editorial->ciudad=$request->ciudad;
            $editorial->telefono=$request->telefono;
            $editorial->correo=$request->correo;
            
            if($editorial->save())
            return response()->json([
                "status"=>$response->status(),
                "message"=>"datos almacenados",
                "error"=>[],
                "data"=>$request->all()
            ]);
        }

    }



    //ACTUALIZAR EDITORIALES
    public function update(Request $request,int $id)
    {
        //        Log::channel('slack')->info('Algo esta sucediendo en Ciudades',[$request]);

        $validacion=Validator::make(
            $request->all(),
            [
                "nombre"=>"required|min:3|max:50",
                "direccion"=>"required|max:100",     
                "ciudad"=>"required|max:30",     
                "telefono"=>"required|max:10",     
                "correo"=>"required|max:60",     
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "direccion.required"=>"el campo :attribute es requerido",
                "ciudad.required"=>"el campo :attribute es requerido",
                "telefono.required"=>"el campo :attribute es requerido",
                "correo.required"=>"el campo :attribute es requerido",
            ]
        );
     if($validacion->fails())
     return response()->json([
        "status"=>400,
        "message"=>"Error en los datos",
        "error"=> $validacion->errors(),
        "data"=>[]
        ],400);

        $response = http::post(env('IP_TEMP')+'api/v1/Editorial/update/id',
        [
            "nombre"=>$request->nombre,
            "direccion"=>$request->direccion,
            "ciudad"=>$request->ciudad,
            "telefono"=>$request->telefono,
            "correo"=>$request->correo,
        ]);

        if($response->successful())
        {
         $editorial =editorial::find($id);
        
            if($editorial)
            {
            
            $editorial->nombre=$request->nombre;
            $editorial->direccion=$request->direccion;
            $editorial->ciudad=$request->ciudad;
            $editorial->telefono=$request->telefono;
            $editorial->correo=$request->correo;
        
            }
            if($editorial->save())
            return response()->json([
                "status"=>$response->status(),
                "message"=>"datos almacenados",
                "error"=>[],
                "data"=>$request->all()
            ]);

        }
      
    }
}
