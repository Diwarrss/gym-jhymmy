<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanceledPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canceled_payments', function (Blueprint $table) {
            $table->id();
            $table->string('description');//descripcion
            //relacion con pago
            $table->foreignId('payment_id')->constrained('payments');
            //relacion con usuario
            $table->foreignId('user_id')->constrained('users');
            //relacion con razones de cancelacion
            $table->foreignId('cancellation_reason_id')->constrained('cancellation_reasons');
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
        Schema::dropIfExists('canceled_payments');
    }
}
