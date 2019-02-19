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
            $table->char('size', 5);
            $table->integer('provider_id');
            $table->boolean('made_by_toker');
            $table->float('base_price');
            $table->float('provision');
            $table->dateTime('valid_from');
            $table->dateTime('valid_to');
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
