<?php

namespace App\Http\Controllers\Controladores\Libreria;

use App\Http\Controllers\Controller;
use App\Models\libreria\sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class controllerSucursal extends Controller
{


    //VER TODAS LAS SUCURSALES
    public function index(Request $request)
    {
        
       // Log::channel('slack')->info('Algo esta sucediendo en Editoriales',[$request]);

        return response()->json([
            "status"=>200,
            "data"=>sucursal::all()
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
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "direccion.required"=>"el campo :attribute es requerido",
                "ciudad.required"=>"el campo :attribute es requerido",
                "telefono.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $response = http::post(env('IP_TEMP')+'api/v1/sucursal/create',
        [
       "nombre"=>$request->nombre,
       "direccion"=>$request->direccion,
       "ciudad"=>$request->ciudad,
       "telefono"=>$request->telefono,
       "correo"=>$request->correo,
        ]);

        if($response->successful())
        {
            $sucursal=new sucursal();

            $sucursal->nombre=$request->nombre;
            $sucursal->direccion=$request->direccion;
            $sucursal->ciudad=$request->ciudad;
            $sucursal->telefono=$request->telefono;
      
            if($sucursal->save())
            return response()->json([
                "status"=>$response->status(),
                "message"=>"datos almacenados",
                "error"=>[],
                "data"=>$request->all()
            ]);

        }        
    }



    //ACTUALIZAR SUCURSALES
    public function update(Request $request,int $id)
    {
      //  Log::channel('slack')->info('Algo esta sucediendo en Ciudades',[$request]);

        $validacion=Validator::make(
            $request->all(),
            [
                "nombre"=>"required|min:3|max:50",
                "direccion"=>"required|max:100",     
                "ciudad"=>"required|max:30",     
                "telefono"=>"required|max:10",         
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "direccion.required"=>"el campo :attribute es requerido",
                "ciudad.required"=>"el campo :attribute es requerido",
                "telefono.required"=>"el campo :attribute es requerido",
            ]
        );
            if($validacion->fails())
            return response()->json([
                "status"=>400,
                "message"=>"Error en los datos",
                "error"=> $validacion->errors(),
                "data"=>[]
                ],400);

        $sucursal =sucursal::find($id);
        
        if($sucursal)
        {
            
            $sucursal->nombre=$request->nombre;
            $sucursal->direccion=$request->direccion;
            $sucursal->ciudad=$request->ciudad;
            $sucursal->telefono=$request->telefono;
            if($sucursal->save())
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
