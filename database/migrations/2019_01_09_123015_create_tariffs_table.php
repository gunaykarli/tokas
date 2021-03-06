<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('tariff_code');
            $table->boolean('status');
            $table->integer('group_id');
            $table->integer('provider_id');
            $table->integer('network_id');
            $table->boolean('made_by_toker');
            $table->boolean('action_tariff');
            $table->float('base_price')->nullable();
            $table->float('provision')->nullable();
            $table->date('valid_from');
            $table->date('valid_to')->nullable();
            $table->integer('is_limited');

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
        Schema::dropIfExists('tariffs');
    }
}
