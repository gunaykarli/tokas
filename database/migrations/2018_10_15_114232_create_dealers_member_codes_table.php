<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealersMemberCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealers_member_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dealer_id');
            $table->string('vodafone_UVP');
            $table->string('vodafone_GVO');
            $table->string('vodafone_DSL_UVP');
            $table->string('mobilcom_debitel_UVP');
            $table->string('energie_user');
            $table->string('yourfone_UVP');
            $table->string('ayyildiz_UVP');
            $table->string('blau_UVP');
            $table->string('otelo_neu');
            $table->string('otelo_alt');
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
        Schema::dropIfExists('dealers_member_codes');
    }
}
