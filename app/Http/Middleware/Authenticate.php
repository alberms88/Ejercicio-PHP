<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Firebase\JWT\JWT;
use App\Models\User;

class Authenticate extends Middleware
{
   public function handle(Request $request, Closure $next)
    {
        define("admin","administrador");
     $getHeaders = apache_request_headers ();
     $token = $getHeaders['Authorization'];
     $key = "kjsfdgiueqrbq39h9ht398erubvfubudfivlebruqergubi";

     $decoded = JWT::decode($token, $key, array('HS256'));

        //primero verificamos que tiene permisos con su id de usuario
     $permiso = User::where('email', $decoded)->get()->first();
        if($permiso->rol != "administrador"){
            return $next($request, $permiso);
        }else{
            echo "no tienes permisos";
        abort(403, "no tiene permisos");
        }
    }
    }
