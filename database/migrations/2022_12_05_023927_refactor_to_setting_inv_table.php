<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorToSettingInvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_inv', function (Blueprint $table) {
            $table->string('store_name')->after('id')->nullable();
            $table->string('phone_number')->after('name')->nullable();
            $table->renameColumn('account_no', 'account_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting_inv', function (Blueprint $table) {
            $table->dropColumn('store_name');
            $table->dropColumn('phone_number');
            $table->renameColumn('account_number', 'account_no');
        });
    }
}
