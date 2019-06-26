<?php

namespace App\Http\Controllers;

use App\cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dompdf\Exception;

class ClienteController extends Controller
{
    public function index()
    {
        try{

            $data = cliente::where('activo', true)->get(); 
            return response()->json(['status'=>'true','data'=>$data,'cod'=>'200'],200);

        }catch(Exception $e){
            return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar obtener los datos','cod'=>'400'],400); 
        }
        
    }

    public function store(Request $request)
    {
        try{
        $data   = $request->all();
        $reglas = $this->validationRules();

        $activo = array('activo'=>'1'); 
        $data = array_merge($data,$activo);

            $v = validator::make($data,$reglas);
            
                if ($v->fails()){
                    dd($v->errors());
                    return redirect()->to($this->getRedirectUrl())
                    ->withInput($request->input())
                    ->withErrors($v->errors());

                } 

                    cliente::create($data);
                    return response()->json(['status'=>'true','msg'=>'Guardado con exito','cod'=>'200'],200);

        }catch(Exception $e){
            return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar insertar los datos','cod'=>'400'],400); 
        }
                
    }

    public function show(cliente $cliente)
    {
        try{
            $data = cliente::where('activo', true)->where('id',$cliente->id)->get();
            return response()->json(['status'=>'true','data'=>$data,'cod'=>'200'],200);
        }catch(Exception $e){
            return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar obtener los datos','cod'=>'400'],400); 
        }
    }

    public function update(Request $request, cliente $cliente)
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

                $concesionarios_id  =  $request->get('concesionarios_id');
                $nombre             =  $request->get('nombre');
                $apellido           =  $request->get('apellido');
                $identificacion     =  $request->get('identificacion');
                $direccion          =  $request->get('direccion');
                $telefono           =  $request->get('telefono');
                $email              =  $request->get('email');

                $cliente->concesionarios_id = $concesionarios_id;
                $cliente->nombre            = $nombre;
                $cliente->apellido          = $apellido;
                $cliente->identificacion    = $identificacion;
                $cliente->direccion         = $direccion;
                $cliente->telefono          = $telefono;
                $cliente->email             = $email;

                $cliente->save();
                return response()->json(['status'=>'true','msg'=>'actualizado con exito','cod'=>'200'],200);
            }catch(Exception $e){
                return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar actualizar los datos','cod'=>'400'],400); 
            }
        }
        // else PATCH
        // metodo patch solo se usa para inhabilitar clientes
        try{
            $cliente->activo = 0;
            $cliente->save();
            return response()->json(['status'=>'true','msg'=>'eliminado con exito','cod'=>'200'],200); 
        }catch(Exception $e){
            return response()->json(['status'=>'false','msg'=>'ocurrio un error al intentar obtener los datos','cod'=>'400'],400); 
        }   
    }

    protected function validationRules() {
        
        return $reglas = array(
            'concesionarios_id' => ['required', 'integer'],
            'nombre'            => ['required', 'string', 'max:50'],
            'apellido'          => ['required', 'string', 'max:100'],
            'identificacion'    => ['required', 'string', 'max:15'],
            'direccion'         => ['required', 'string', 'max:200'],
            'telefono'          => ['required', 'string', 'max:14'],
            'email'             => ['required', 'string', 'max:50','unique:clientes,email'],
        );
    }

    protected function validationRulesUp() {
        
        return $reglas = array(
            'concesionarios_id' => ['required', 'integer'],
            'nombre'            => ['required', 'string', 'max:50'],
            'apellido'          => ['required', 'string', 'max:100'],
            'identificacion'    => ['required', 'string', 'max:15'],
            'direccion'         => ['required', 'string', 'max:200'],
            'telefono'          => ['required', 'string', 'max:14'],
        );
    }
}
