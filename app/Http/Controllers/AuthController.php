<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Jobs\MailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use \sdtClass;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use PhpParser\Builder\Use_;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use  App\Notifications\SendSMS;
use App\Http\Controllers\Users;






class AuthController extends Controller
{
   
    public function register(Request $request)
    {   
        $validacion=Validator::make($request->all(),
        [
            'name'=>'required',
           'phone'=>'required',
            'email'=>'required|email|max:255|unique:users',
            'password'=>'required',
        ],
        [
            "name.required"=>"el campo :attribute es requerido",
            "email.required"=>"el campo :attribute es requerido",
            "password.required"=>"el campo :attribute es requerido",
        ]);

        if($validacion->fails())
        {
            return response()->json([
                'status'=>false,
                'message'=>'Error en las validaciones',
                'error'=> $validacion->errors()
            ], 401);
        }

         $user =User::create([
            "name"=>$request->name,
            "phone"=>$request->phone,
            "mobile_verify_code"=>random_int(1111,9999),
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
        ]);
       
        $user->save();
        $url=URL::temporarySignedRoute('verify',now()->addMinutes(30),['user'=>$user->id]);        
        MailJob::dispatch($user, $url)
        ->delay(now()->addSeconds(20))
        ->onQueue('emails');

        return response()->json(["mensaje" => "Usuario registrado correctamente, espera nuestro mensaje"], 201);

             
    }
     

    public function verified(Request $request)
    {
        $user=User::find($request->user);
       
        $response = Http::post('https://rest.nexmo.com/sms/json', [
            "from"=>"Pablo Vazquez",
            'api_key' => "a5f228dd",
            'api_secret' => "GRrWz6F07QPQ3g0z",
            'to' => 52 .$user->phone,
            'text' => "Tu codigo de verificacion es: ".$user->mobile_verify_code,
        ]);

        if ($response->successful())
         {
            return response()->json([
                'message' => 'Codigo enviado',
                
            ], 200);
        } 
        else 
        {
            return response()->json($response->json(),400);
        }      
    }
    


    public function verifyNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_verify_code' => 'required | integer' 
        ], [
            
        ]);

        if($validator->fails())
        return response()->json([
            'status'=>400,
            'msg'=>'Error en las validaciones',
            'error'=> $validator->errors()
        ], 401);

    $user = User::where('mobile_verify_code', $request->mobile_verify_code)->first();

      
      
    if($request->mobile_verify_code==$user->mobile_verify_code)
    {
        if (!$user)
        {
            abort(401,"usuario no encontrado");
        }else
        {
            $id=$user->id;
            $userupdate = User::find($id);
            $userupdate->status=true;
            $userupdate->save();
        }

        return response()->json([
            "status"=>200,
            "message"=>"USUARIO VERIFICADO",
            "Usuario"=>$userupdate,
            "error"=>[],
            //"user"=>$user,
            "data"=>$request->all()
        ]);   
    }
         
    }

   public function confirm(Request $request)
    { 
         $url=URL::temporarySignedRoute('verify',now()->addMinutes(30));        
         return response()->json(["url"=>$url],200);
    }  
    



    public function login(Request $request)
    {
        $validacion = Validator::make($request->all(),
            [  
                'email'=>'required|email',
                'password'=>'required',  
            ],
            [
                "email.required"=>"el campo :attribute es requerido",
                "password.required"=>"el campo :attribute es requerido",
            ]);

           if($validacion->fails())
           {
            return response()->json([
                'status'=>false,
                'msg'=>'Error en las validaciones',
                'error'=> $validacion->errors(),
                "data"=>null
            ], 401);
           } 

           $user = User::where('email', $request->email)->first();
           if (! $user || ! Hash::check($request->password, $user->password)){
            return response()->json(
             [
                'status'=>false,
                'msg'=>'ERRROR EN LOS DATOS',
                "data"=>null,
                "error"=>[]

             ], 401);

           }
            return response()->json([
                'status'=>200,
                'msg'=>"Inicio sesion correctamente",
                'data'=>[
                    "user"=>$user,
                  "token"=>$user->createToken("Token")->plainTextToken]
            ],200);
    }

    public function logout(Request $request)
    {
        return response()->json([
        "status"=>200,
        "msg"=>"la sesion se ha cerrado correctamente",
        "error"=>null,
        "data"=>[
            "user"=>$request->user,
           "del"=>$request->user()->tokens()->delete()
        ]
     ],200);

    }

//---------------EXPERIMENTANDO-------------------
    public function registerh(Request $request)
    {
        $validacion=Validator::make($request->all(),
        [
            'name'=>'required',
            'email'=>'required|email|max:255|unique:users',
            'password'=>'required',
        ],
        [
            "name.required"=>"el campo :attribute es requerido",
            "email.required"=>"el campo :attribute es requerido",
            "password.required"=>"el campo :attribute es requerido",
        ]
       );

        if($validacion->fails())
            return response()->json([
                'status'=>false,
                'msg'=>'Error en las validaciones',
                'error'=> $validacion->errors()
            ], 401);

            $response = http::withToken($request->bearerToken())->post(env('IP_TEMP')+'api/v1/login/register',
         [
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$request->password
         ]);

        if($response->successful())
            $user =User::create([
                "name"=>$request->name,
                "email"=>$request->email,
                "password"=>Hash::make($request->password)
            ]);

            return response()->json([
                'status'=>$response->status(),
                'msg'=>'cuenta creada',
                'error'=>null,
                'data'=>$user
            
            ],201);
    
        
    }

    public function loginh(Request $request)
    {
        $validacion = Validator::make(
            $request->all(),
            [  
                'email'=>'required|email',
                'password'=>'required',
            ],
            [
                "email.required"=>"el campo :attribute es requerido",
                "password.required"=>"el campo :attribute es requerido",
            ]);

           if($validacion->fails())
            return response()->json([
                'status'=>false,
                'msg'=>'Error en las validaciones',
                'error'=> $validacion->errors(),
                "data"=>null
            ], 401);
           
            $response = http::withToken($request->bearerToken())->post(env('IP_TEMP')+'api/v1/login/login',
            [
               "email"=>$request->email,
               "password"=>$request->password
            ]);
   
           if($response->successful())
           $user = User::where('email', $request->email)->first();
           if (! $user || ! Hash::check($request->password, $user->password)){
            return response()->json(
             [
                'status'=>false,
                'msg'=>'ERRROR EN LOS DATOS',
                "data"=>null,
                "error"=>[]

             ], 401);

           }
            return response()->json([
                'status'=>$response->status(),
                'msg'=>"Inicio sesion correctamente",
                'data'=>[
                    "user"=>$user,
                  "token"=>$user->createToken("Token")->plainTextToken]
            ],200);
    }

    public function logouth(Request $request)
    {
        $response = http::withToken($request->bearerToken())->post(env('IP_TEMP')+'api/v1/login/logout');
        return response()->json([
            "status"=>$response->status(),
            "msg"=>"la sesion se ha cerrado correctamente",
            "error"=>null,
            "data"=>[
                "user"=>$request->user,
            "del"=>$request->user()->tokens()->delete()
            ]
        ],200);

    }


/* LIBRERIA
$basic  = new \Vonage\Client\Credentials\Basic("a5f228dd", "GRrWz6F07QPQ3g0z");
        $client = new \Vonage\Client($basic);
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("528718458147",'UTT' , 'HOLAAA TE LLEGO EL NUEVO')
        );*/

        /*$message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }*/
//EL MENSAJE QUE TE LLEGARA CUANDO CONFIRMES
public function url(Request $request)
{
    // $user->notify(new SendSMS());
    if(!$request->hasValidSignature())
    {
        abort(401);
    }
    return response()->json(["hello word"],200);
}

//FUNCION PARA PROBAR QUE ENVIA MENSAJES
public function smsenviar(Request $request)
{

    $telefono="8718458147";
    $response = Http::post('https://rest.nexmo.com/sms/json', [
        "from"=>"Pablo Vazquez",
        'api_key' => "a5f228dd",
        'api_secret' => "GRrWz6F07QPQ3g0z",
        'to' => 52 .$telefono,
        'text' => "Tu codigo de verificacion es: ",
    ]);

   
    
    if ($response->successful())
     {
        return response()->json([
            'message' => 'Codigo enviado',
            
        ], 200);
    } 
    else 
    {
        return response()->json($response->json(),400);
    }
}


}