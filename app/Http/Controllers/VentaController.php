<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use App\Models\User;
use App\Middleware\Authenticate;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;

class VentaController extends Controller
{
	public function createventa(Request $request){

		$response = "";


        //Leer el contenido de la petición

		$data = $request->getContent();

        //Decodificar el json

		$data = json_decode($data);

		if($data){

			$venta = new Venta();

            //TODO: Validar los datos antes de guardar el usuario

			$usuario = User::where('email', $data->email)->get()->first();

			$venta->name_venta = $data->name_venta;
			$venta->stock = $data->stock;
			$venta->precio = $data->precio;
			$venta->cards_id = $data->cards_id;
			$venta->user_id = $usuario->id;

			try{
				$venta->save();
				$response = "OK, la venta se creo correctamente";
			}catch(\Exception $e){
				$response = $e->getMessage();
			}


		}


		return response($response);
	}
	public function listaventas(Request $request,$name){

		$venta = Venta::where('name_venta','like','%'. $name .'%')->get();


		$data = [];

           //muestro la lista de ventas

		foreach ($venta as $venta1){

			$data[] =    [

				'name' => $venta1->name_venta,
				'quantity' => $venta1->stock,
				'price' => $venta1->precio,
				'Id' => $venta1->cards_id

			];
		}

		return $data;
	}
	public function listaCompra(Request $request,$name){

		//Funcion para mostrar la lista de la compra


		$compra = Venta::where('name_venta','like','%'. $name .'%')->orderBy('precio','asc')->get();

		$headers = getallheaders();
		$key = "kjsfdgiueqrbq39h9ht398erubvfubudfivlebruqergubi";
		
		$decoded = JWT::decode($headers['Authorization'], $key, array('HS256'));
		print_r($decoded);
		
		$nombre_usuario1 = User::find($decoded->id);

		$data = [];

		echo $compra;

		foreach ($compra as $compra1){

			$data[] =    [

				'name' => $compra1->nombre_venta,
				'quantity' => $compra1->cantidad,
				'price' => $compra1->cards_id,
				'nombre_usuario' => $nombre_usuario1->nombre
			];
		}

		return $data;
	}



}