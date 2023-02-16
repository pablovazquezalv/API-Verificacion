<?php

namespace App\Http\Controllers\Controladores\Libreria;

use App\Http\Controllers\Controller;
use App\Models\libreria\libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
class controllerLibro extends Controller
{
    public function index(Request $request)
    {
        
       // Log::channel('slack')->info('Algo esta sucediendo en Editoriales',[$request]);

        return response()->json([
            "status"=>200,
            "data"=>libro::all()
        ]);
    }

    //CREAR
    public function create(Request $request)
    {
      Log::channel('slack')->info('Algo esta sucediendo en Editoriales',[$request]);

            $validacion=Validator::make(
            $request->all(),
            [
                "nombre"=>"required|min:3|max:50",
                "autor"=>"required|max:50",     
                "editorial"=>"required|integer",     
                "precio"=>"required|integer",         
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "autor.required"=>"el campo :attribute es requerido",
                "editorial.required"=>"el campo :attribute es requerido",
                "precio.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $response = http::WithToken('')->post(env('IP_TEMP')+'api/v1/libro/create',
        [
            "nombre"=>$request->nombre,
            "autor"=>$request->autor,
            "editorial"=>$request->editorial,
            "precio"=>$request->precio
        ]);

        if($response->successful())
        {

            $libro=new libro();

        $libro->nombre=$request->nombre;
        $libro->autor=$request->autor;
        $libro->editorial=$request->editorial;
        $libro->precio=$request->precio;
        
        if($libro->save())
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
                "autor"=>"required|max:50",     
                "editorial"=>"required|integer",     
                "precio"=>"required|integer",         
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "autor.required"=>"el campo :attribute es requerido",
                "editorial.required"=>"el campo :attribute es requerido",
                "precio.required"=>"el campo :attribute es requerido",
            ]
        );
     if($validacion->fails())
     return response()->json([
        "status"=>400,
        "message"=>"Error en los datos",
        "error"=> $validacion->errors(),
        "data"=>[]
        ],400);
        $response = http::post(env('IP_TEMP')+'api/v1/libro/update',
        [
       "nombre"=>$request->nombre,
       "autor"=>$request->autor,
       "editorial"=>$request->editorial,
       "precio"=>$request->precio
        ]);

        $libro =libro::find($id);
        
        if($libro)
        {
            
            
        $libro->nombre=$request->nombre;
        $libro->autor=$request->autor;
        $libro->editorial=$request->editorial;
        $libro->precio=$request->precio;
        
        }

        if($libro->save())
        return response()->json([
            "status"=>$response->status(),
            "message"=>"datos almacenados",
            "error"=>[],
            "data"=>$request->all()
        ]);
    }
}
