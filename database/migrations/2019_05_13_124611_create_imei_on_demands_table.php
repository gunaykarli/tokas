<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImeiOnDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imei_on_demands', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('provider_id');
            $table->integer('vf_gsm_id');
            $table->integer('IMEI');
            $table->string('device');
            $table->integer('package');
            $table->string('VO');
            $table->smallInteger('status');
            $table->integer('contract_id');
            $table->string('user');
            $table->integer('salesperson_id');
            $table->date('date');
            $table->date('award_date');

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
        Schema::dropIfExists('imei_on_demands');
    }
}
