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
            $table->double('back');//espalda
            $table->double('chest');//pecho
            $table->double('claf');//pantorrilla
            $table->double('leg');//pierna
            $table->double('abdomen');//abdomen
            $table->double('arm');//brazo
            $table->double('waist');//cintura
            $table->double('weight');//peso
            $table->double('size');//talla
            //relacion con usuario
            $table->foreignId('user_id')->constrained('users');
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
