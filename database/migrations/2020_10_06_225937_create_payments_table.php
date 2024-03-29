<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('value');  ///valor a pagar
            $table->date('to_date');  ///fecha inicio
            $table->date('from_date');  ///fecha terminacion
            $table->boolean('state');  ///fecha terminacion
            //relacion con usuario que pago
            $table->foreignId('user_id')->constrained('users');
            //relacion con usuario creador
            $table->foreignId('creator_user_id')->constrained('users');
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
        Schema::dropIfExists('payments');
    }
}
