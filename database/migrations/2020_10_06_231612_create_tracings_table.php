<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracings', function (Blueprint $table) {
            $table->id();
            $table->string('back');//espalda
            $table->string('chest');//pecho
            $table->string('calf');//pantorrilla
            $table->string('leg');//pierna
            $table->string('arm');//brazo
            $table->string('waist');//cintura
            $table->string('weight');//peso
            $table->string('size');//talla
            $table->boolean('state');//talla
            //relacion con usuario
            $table->foreignId('user_id')->constrained('users');
            //relacion con estado
            //$table->foreignId('state_id')->constrained('states');
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
        Schema::dropIfExists('tracings');
    }
}
