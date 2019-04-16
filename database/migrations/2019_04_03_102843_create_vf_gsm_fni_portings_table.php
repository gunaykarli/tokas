<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVfGsmFniPortingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vf_gsm_fni_portings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('VF_gsm_id');
            $table->integer('provider_id');
            $table->date('porting_date');
            $table->integer('analogue_conn_number');
            $table->integer('digital_conn_number');
            $table->string('name_1');
            $table->string('surname_1');
            $table->string('name_2');
            $table->string('surname_2');
            $table->string('name_3');
            $table->string('surname_3');
            $table->string('name_4');
            $table->string('surname_4');
            $table->boolean('same_contact_address');
            $table->integer('area_code');
            $table->string('main_phone_number');
            $table->string('next_number_1');
            $table->string('next_number_2');
            $table->string('next_number_3');
            $table->string('next_number_4');
            $table->string('next_number_5');
            $table->string('next_number_6');
            $table->string('next_number_7');
            $table->string('next_number_8');
            $table->string('next_number_9');
            $table->boolean('porting_all_numbers');
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
        Schema::dropIfExists('vf_gsm_fni_portings');
    }
}
