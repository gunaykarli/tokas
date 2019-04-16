<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVfGsmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vf_gsms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('VF_credit_activation_id');
            $table->integer('subscriber_id');
            $table->string('SIM_serial_number');
            $table->smallInteger('SIM_IMEI_type');
            $table->string('tariff_and_services');
            $table->integer('tariff_id');
            $table->boolean('same_contact_address');
            $table->smallInteger('connection_overview');
            $table->smallInteger('represent_destination_number');
            $table->string('supplementary_services');
            $table->string('data _services');
            $table->smallInteger('mailbox');
            $table->smallInteger('call_barring');
            $table->smallInteger('show_phone_numbers');
            $table->string('disabled_card_id');
            $table->smallInteger('disability_degree');

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
        Schema::dropIfExists('vf_gsms');
    }
}
