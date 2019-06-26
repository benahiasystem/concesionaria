<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('concesionarios_id')->unsigned;
            $table->string('nombre',50);
            $table->string('apellido',100);
            $table->string('identificacion',15);
            $table->string('direccion',200);
            $table->string('telefono',15);
            $table->string('email',50)->unique();
            $table->integer('activo');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropForeignIfExists('cliente-concesionario_id-cliente_foreign');
        Schema::dropIfExists('clientes');
    }
}
