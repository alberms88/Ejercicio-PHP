<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\ColectionController;
use App\Models\User;
use App\Models\Card;
use App\Models\Colection;

class CardController extends Controller
{
    //funcion para crear carta

    public function CreateCard(Request $request)
    {

        $response = "";
        //Leo el contenido de la petición
        $data = $request->getContent();

        //Decodificar el json
        $data = json_decode($data);

        //Si hay un json válido, crear el card
        if($data){
            $card = new Card();

            //TODO: Validar los datos antes de guardar el card

            $card->name = $data->name;
            $card->description = $data->description;
            $card->colection = $data->colection;
            $namecolection = $data->colection;

            if(Colection::where('namecolection', $namecolection)->get()->first()){

                echo "Se añadio correctamente";

            }
            else{
                $colection = new Colection();
                $colection->namecolection = $data->colection;
                $colection->save();

            }
            


            try{
                $card->save();
                $response = "OK";
            }catch(\Exception $e){
                $response = $e->getMessage();
            }

        }

        return response($response);

    }

    public function listCard($cardname){

        $response = "";


        $cards = card::where('name','like','%'. $cardname .'%')->get();


        $response= [];

        foreach ($cards as $card) {
            $response[] = [
                "id" => $card->id,
                "nombre" => $card->name,
                "coleccion" => $card->colection,
                "descripcion" => $card->description
            ];
        }
        return response()->json($response);
    }
}