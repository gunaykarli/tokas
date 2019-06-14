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

            $table->integer('contract_id')->nullable();
            $table->string('AO_bundle_offering_code')->nullable();
            $table->integer('group_change_group_id')->nullable();
            $table->boolean('objection')->nullable();
            $table->boolean('additional_contract')->nullable();
            $table->integer('customer_number')->nullable();
            $table->boolean('activation_with_hardware')->nullable();

            $table->string('SIM_serial_number')->nullable();
            $table->integer('SIM_IMEI_type')->nullable();
            $table->integer('tariff_id')->nullable();
            $table->string('tariff_and_services')->nullable();
            $table->boolean('different_invoice_address')->nullable();
            $table->boolean('different_home_address')->nullable();
            $table->string('connection_overview')->nullable();
            $table->string('represent_destination_number')->nullable();
            $table->string('supplementary_services')->nullable();
            $table->string('data_services')->nullable();
            $table->string('mailbox')->nullable();
            $table->string('call_barring')->nullable();
            $table->string('show_phone_numbers')->nullable();
            $table->string('disabled_card_id')->nullable();
            $table->smallInteger('disability_degree')->nullable();

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
