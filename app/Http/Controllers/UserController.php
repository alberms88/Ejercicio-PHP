<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;

use App\Models\user;

class userController extends Controller
{
    //

    public function createUser(Request $request)
    {

        $response = "";
        
        //Leo el contenido de la petición
        
        $data = $request->getContent();

        //Decodifico el json
        
        $data = json_decode($data);

        //Si hay un json válido, crear el soldado
        
        if($data){
            $user = new User();

            //valido datos antes de crear el usuario

            $user->nombre = $data->nombre;
            $user->email = $data->email;
            $user->rol = $data->rol;
            $user->password = password_hash($data->password, PASSWORD_DEFAULT);

            try{
                $user->save();
                $response = "OK";
            }catch(\Exception $e){
                $response = $e->getMessage();
            }

        }


        return response($response);

    }

    public function login(Request $request){
        $respuesta = "";

        
        $data = $request->getContent();

       
        $data = json_decode($data);

        if($data){

            if(isset($data->email)&&isset($data->password)){

                $user = User::where("email",$data->email)->first();

                if($user){

                    if(Hash::check($data->password, $user->password)){

                        $key = "kjsfdgiueqrbq39h9ht398erubvfubudfivlebruqergubi";
                        
                        $token = JWT::encode($data->email,$key);

                        $user->api_token = $token;

                        $user->save();

                        $respuesta = $token;

                    }else{
                        $respuesta = "Contraseña incorrecta";
                    }

                }else{
                    $respuesta = "Usuario no encontrado";
                }

            }else{
                $respuesta = "Faltan data";
            }

        }else{
            $respuesta = "data incorrectos";
        }


        return response($respuesta);

    }
    public function resetPassword(Request $request){
        $respuesta = "";

        //Procesar los data recibidos
        $data = $request->getContent();

        //Verificar que hay data
        $data = json_decode($data);

        if($data){

            if(isset($data->email)){

                $user = User::where("email",$data->email)->first();

                if($user){

                    if($data->email == $user->email){
                        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

                        $password = substr(str_shuffle($permitted_chars), 0, 10);
                        $respuesta = $password;

                        $user->password = Hash::make($password);
                        try{
                            $user->save();
                            $response = "OK";
                        }catch(\Exception $e){
                            $response = $e->getMessage();
                        }

                    }else{
                        $respuesta = "email incorrecto";
                    }

                }else{
                    $respuesta = "Usuario no encontrado";
                }

            }else{
                $respuesta = "Faltan datos";
            }

        }else{
            $respuesta = "datos incorrectos";
        }
        
        return response($respuesta);
    }
}