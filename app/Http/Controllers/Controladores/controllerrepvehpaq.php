<?php

namespace App\Http\Controllers\Controladores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Paqueteria\RepartidorVehiculoPaquete;
use Illuminate\Support\Facades\Http;

class controllerrepvehpaq extends Controller
{
        //VER
        public function index(Request $request)
        {
           // Log::channel('slack')->info('Algo esta sucediendo en Envios',[$request]);

            return response()->json([
                "status"=>200,
                "data"=>RepartidorVehiculoPaquete::all()
            ]);
        }


    public function create(Request $request)
    {
          // Log::channel('slack')->info('Algo esta sucediendo en Envios',[$request]);

          $validacion=Validator::make(
            $request->all(),
            [
                "repartidor_id"=>"required",
                "vehiculo_id"=>"required",
                "fecha"=>"required|date",
                "paquete_id"=>"required",
            ],
            [
                "repartidor_id.required"=>"el campo :attribute es requerido",
                "vehiculo_id.required"=>"el campo :attribute es requerido",
                "fecha.required"=>"el campo :attribute es requerido",
                "paquete_id.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $enviopaquete= new RepartidorVehiculoPaquete();

        $enviopaquete->repartidor_id=$request->repartidor_id;
        $enviopaquete->vehiculo_id=$request->vehiculo_id;
        $enviopaquete->fecha=$request->fecha;
        $enviopaquete->paquete_id=$request->paquete_id;
        
        if($enviopaquete->save())
        return response()->json([
            "status"=>200,
            "message"=>"datos almacenados",
            "error"=>[],
            "data"=>$request->all()
        ]);

        
        
    }


    

    public function update(Request $request,int $id)
    {
        Log::channel('slack')->info('Algo esta sucediendo en Repartidores',[$request]);

        $validacion=Validator::make(
            $request->all(),
            [
                "repartidor_id"=>"required",
                "vehiculo_id"=>"required",
                "fecha"=>"required|date",
                "paquete_id"=>"required",
            ],
            [
                "repartidor_id.required"=>"el campo :attribute es requerido",
                "vehiculo_id.required"=>"el campo :attribute es requerido",
                "fecha.required"=>"el campo :attribute es requerido",
                "paquete_id.required"=>"el campo :attribute es requerido",
            ]
        );
        if($validacion->fails())
        return response()->json([
            "status"=>400,
            "message"=>"Error en los datos",
            "error"=> $validacion->errors(),
            "data"=>[]
        ],400);

        $response = http::post(env('IP_TEMP')+'api/v1/envio/update',
        [
            "repartidor_id"=>$request->repartidor_id,
            "vehiculo_id"=>$request->vehiculo_id,
            "fecha"=>$request->fecha,
            "paquete_id"=>$request->paquete_id,
        ]);


        $enviopaquete =RepartidorVehiculoPaquete::find($id);
    
        if($enviopaquete)
        {
            
            $enviopaquete->repartidor_id=$request->repartidor_id;
            $enviopaquete->vehiculo_id=$request->vehiculo_id;
            $enviopaquete->fecha=$request->fecha;
            $enviopaquete->paquete_id=$request->paquete_id;
        
            if($enviopaquete->save())
            return response()->json([
                "status"=>$response->status(),
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

      
}
