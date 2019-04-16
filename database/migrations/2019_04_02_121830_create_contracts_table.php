<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('contract_type');
            $table->integer('provider_id');
            $table->integer('customer_id');
            $table->integer('salesperson_id');
            $table->integer('office_id');
            $table->integer('dealer_id');
            $table->integer('VO_id');
            $table->integer('tariff_id');
            $table->date('contract_start');
            $table->smallInteger('status');
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
        Schema::dropIfExists('contracts');
    }
}
