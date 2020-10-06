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
            //relacion con usuario
            $table->foreignId('user_id')->constrained('users');
            //relacion con usuario
            $table->foreignId('creator_user_id')->constrained('users');
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
