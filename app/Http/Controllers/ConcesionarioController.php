<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\concesionarios;
use PHPUnit\Framework\Constraint\Exception;

class ConcesionarioController extends Controller
{
   
    public function index()
    {
        
        try{
            $data = concesionarios::where('activo', true)->get();
            return response()->json(['status'=>'true','data'=>$data,'cod'=>'200'],200);
        }catch(Exception $e){
            return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar obtener los datos','cod'=>'400'],400); 
        }
    }

    public function store(Request $request)
    {
        try{
            $data = $request->all();
            $reglas = $this->validationRules();
            $activo = array('activo'=>'1'); 
            $data = array_merge($data,$activo);

            $v = validator::make($data,$reglas);
            
                if ($v->fails()){
                    dd($v->errors());
                    return redirect()->back()
                    ->withErrors($v->errors());
                } 

                    concesionarios::create($data);
                    return response()->json(['status'=>'true','msg'=>'guardado con exito','cod'=>'200'],200);
        }catch(Exception $e){
            return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar obtener los datos','cod'=>'400'],400); 
        }
    }

    public function show(concesionarios $concesionario)
    {   try{
            $data = concesionarios::where('activo', true)->where('id',$concesionario->id)->get();
            return response()->json(['status'=>'true','data'=>$data,'cod'=>'200'],200);
        }catch(Exception $e){
            return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar obtener los datos','cod'=>'400'],400); 
        }
        
    }

    public function update(Request $request, concesionarios $concesionario)
    {
        $metodo = $request->method();
      
        if($metodo=="PUT"){

            try{

                // validador
                $data = $request->all();
                $reglas = $this->validationRulesUp();

                $activo = array('activo'=>'1'); 
                $data = array_merge($data,$activo);
        
                    $v = validator::make($data,$reglas);
                    
                        if ($v->fails()){
                            dd($v->errors());
                            return redirect()->to($this->getRedirectUrl())
                            ->withInput($request->input())
                            ->withErrors($v->errors());
                        } 

                            $nombre     =  $request->get('nombre');
                            $localidad  =  $request->get('localidad');
                            $ciudad     =  $request->get('ciudad');
                            $region     =  $request->get('region');
                
                                $concesionario->nombre    = $nombre;
                                $concesionario->localidad = $localidad;
                                $concesionario->ciudad    = $ciudad;
                                $concesionario->region    = $region;

                                    $concesionario->save();
                                    return response()->json(['status'=>'true','msg'=>'actualizado con exito','cod'=>'200'],200);

            }catch(Exception $e){
                return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar obtener los datos','cod'=>'400'],400); 
            } 
        }
        // else PATCH
        // metodo patch solo se usa para inhabilitar clientes

        try{
            $concesionario->activo = 0;
            $concesionario->save();
            return response()->json(['status'=>'true','msg'=>'eliminado con exito','cod'=>'200'],200); 
        }catch(Exception $e){
            return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar obtener los datos','cod'=>'400'],400); 
        }

    }

     protected function validationRules() {
        
        return $reglas = array(
            'nombre'    => ['required', 'string', 'max:50'],
            'localidad' => ['required', 'string', 'max:100'],
            'ciudad'    => ['required', 'string', 'max:100'],
            'region'    => ['required', 'string', 'max:200'],
        );
    }

    protected function validationRulesUp() {
        
        return $reglas = array(
            'nombre'    => ['required', 'string', 'max:50'],
            'localidad' => ['required', 'string', 'max:100'],
            'ciudad'    => ['required', 'string', 'max:100'],
            'region'    => ['required', 'string', 'max:200'],
        );
    }

}
