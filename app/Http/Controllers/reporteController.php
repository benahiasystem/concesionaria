<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cliente;
use App\concesionarios;
use PDF;

class reporteController extends Controller
{
    public function viewReportes(){
        return view('viewReportes');
    }

    public function clientes($idc,$idl)
    {
        /*$clientes = cliente::where('activo', true)->get(); 
        $pdf = PDF::loadView('pdfCliente',compact('clientes'));
        $pdf->setPaper('a4','landscape');
        return $pdf->stream('Clientes.pdf');*/

       // return $idc . "-" . $idl; // . $localidad;
       return reporte_clientes();
    }

    
    private function reporte_clientes() {
        $clientes = cliente::from('cliente as cli')
        ->join('concesionarios as con', function($join){
            $join->on('cli.concesionarios_id', '=', 'con.id');
        })
        ->select('cli.nombre', 'cli.apellido', 'cli.identificacion', 'cli.direccion', 'cli.telefono')
        ->where('cli.activo', true)
        ->where('con.activo', true)
        ->get(); 

        return $clientes;
    }

    public function concesionario(){
        return "concesionarios";
    }

    public function datosconcesionarios() {

        try{
            $data = concesionarios::where('activo', true)
            ->select("id","nombre","localidad")
            ->get();
            return response()->json(['status'=>'true','data'=>$data,'cod'=>'200'],200);
        }catch(Exception $e){
            return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar obtener los datos','cod'=>'400'],400); 
        }
    }
}