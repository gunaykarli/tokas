<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLawTextVodafoneTariff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('law_text_vodafone_tariff', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vodafone_tariff_id');
            $table->integer('law_text_id');
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
        Schema::dropIfExists('law_text_vodafone_tariff');
    }
}
