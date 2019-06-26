<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\concesionarios;
use App\cliente;

class ClienteConcesionarioController extends Controller
{
    public function index($id)
    {
        $concesionario = concesionarios::find($id);

        if($concesionario){
        $cliente = $concesionario->cliente;
        return response()->json(['datos'=> $cliente],200);
        }else{
            return response()->json(['mensaje'=> "un error"],422);
        }
        
       // return $cliente = cliente::find(2)->nombre;

    }

    public function show($id, $idC)
    {
        $concesionario = concesionarios::find($id)->id;

        if ($concesionario){
        $cliente = cliente::find($idC);
        return response()->json(['datos'=>$cliente],200);
        }else{
            return redirect()->back()
            ->withErrors("un error");
        }
       
    }
}
