<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    protected $table ="clientes";
    protected $fillable = ["concesionarios_id","nombre","apellido","identificacion","direccion","telefono","email","activo"];
    protected $hidden = ["created_at","updated_at"];

    public function concesionarios(){
        return $this->belongsTo('App\concesionarios');
    }
} 


