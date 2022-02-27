<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_payment');
            $table->integer('id_product');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('disc');
            $table->integer('status');
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
        Schema::dropIfExists('h_sales');
    }
}
