<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Firebase\JWT\JWT;
use App\Models\User;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        define("admin","administrador");

        $getHeaders = apache_request_headers ();

        $token = $getHeaders['Authorization'];

        $key = "kjsfdgiueqrbq39h9ht398erubvfubudfivlebruqergubi";

        $decoded = JWT::decode($token, $key, array('HS256'));


        //primero verificamos que tiene permisos con su id de usuario
        
        if($decoded->rol == "admin"){

            return $next($request);

        }else{

            echo "no tienes permisos";

            abort(403, "un admin no puede crear ventas");
        }
    }
}