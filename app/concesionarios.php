<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class concesionarios extends Model
{
    protected $table ="concesionarios";
    protected $fillable = ["nombre","localidad","ciudad","region","activo"];
    protected $hidden = ["created_at","updated_at"];

    public function cliente(){
       return $this->hasMany('App\cliente');
    }


}
