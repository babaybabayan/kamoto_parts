<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingInvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_inv', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name');
            $table->string('account_no');
            $table->string('name');
            $table->timestamps();
        });
        DB::table('setting_inv')->insert([
            'bank_name' => 'BCA',
            'account_no' => '379.011.0969',
            'name' => 'YUFIRA'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_inv');
    }
}
