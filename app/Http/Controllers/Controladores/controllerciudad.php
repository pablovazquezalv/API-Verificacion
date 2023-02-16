<?php

namespace App\Http\Controllers\Controladores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Paqueteria\Ciudad;
use Illuminate\Support\Facades\Http;

class controllerciudad extends Controller
{

    //VER
    public function index(Request $request)
    {
        
      //  Log::channel('slack')->info('Algo esta sucediendo en Ciudades',[$request]);

        return response()->json([
            "status"=>200,
            "data"=>Ciudad::all()
        ]);
    }

    //CREAR
    public function create(Request $request)
    {
           Log::channel('slack')->info('Algo esta sucediendo en Ciudades',[$request]);
           $validacion=Validator::make(
            $request->all(),
            [
                "nombre"=>"required|min:3|max:50",
                "estado_id"=>"required|",     
            ],
            [
                "nombre.required"=>"el campo :attribute es requerido",
                "estado_id.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $ciudad= new Ciudad();
        $ciudad->nombre=$request->nombre;
        $ciudad->estado_id=$request->estado_id;
        if($ciudad->save())
        return response()->json([
            "status"=>200,
            "message"=>"datos almacenados",
            "error"=>[],
            "data"=>$request->all()
        ]);   
    }

    public function update(Request $request,int $id)
    {
        Log::channel('slack')->info('Algo esta sucediendo en Ciudades',[$request]);

        $validacion=Validator::make(
        $request->all(),
        [
            "nombre"=>"required|min:3|max:50",
            "estado_id"=>"required",     
        ],
        [
            "nombre.required"=>"el campo :attribute es requerido",
            "estado_id.required"=>"el campo :attribute es requerido",
        ]
     );
     if($validacion->fails())
     return response()->json([
        "status"=>400,
        "message"=>"Error en los datos",
        "error"=> $validacion->errors(),
        "data"=>[]
        ],400);

        $ciudad =Ciudad::find($id);
        
        if($ciudad)
        {
        $ciudad->nombre=$request->nombre;
        $ciudad->estado_id=$request->estado_id;
        
        if($ciudad->save())
        return response()->json([
            "status"=>200,
            "message"=>"datos almacenados",
            "error"=>[],
            "data"=>$request->all()
        ]);
        }else
        {
            return response()->json([
                "status"=>400,
                "message"=>"datos no encontrados",
                "error"=>[],
                "data"=>$request->all()]);
        }

    }


    public function consultaJoin(Request $request)
    {
        $ciudad=Ciudad::Select("ciudades.nombre","colonias.nombre")
        ->join("colonias","ciudad_id","=","colonias.id")
        ->get();
        
        return response ()->json([

            "status"    =>200,
            "message"   =>"Resultados",
            "error"     =>[],
            "data"      =>$ciudad
        ]);
    }


    //CONSULTA
    public function indexV2()
        {
            $ciudad=Ciudad::with("Colonia")->get();
            
            return response ()->json([

                "status"    =>200,
                "message"   =>"Resultados",
                "error"     =>[],
                "data"      =>$ciudad
            ]);
        }
}
