<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVfDcChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vf_dc_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id');
            $table->date('contract_start');
            $table->date('entry_date');
            $table->integer('phone_number_NDC');
            $table->integer('phone_number_MSISDN');
            $table->string('previous_customer_name');
            $table->date('birth_date');
            $table->smallInteger('IMEI_type');
            $table->boolean('same_contact_address');
            $table->integer('tariff_id');
            $table->smallInteger('connection_overview');
            $table->smallInteger('represent_destination_number');
            $table->smallInteger('objection');
            $table->boolean('additional_contract');
            $table->integer('customer_number');
            $table->string('password');
            $table->string('supplementary_services');
            $table->string('data _services');
            $table->smallInteger('mailbox');
            $table->smallInteger('call_barring');
            $table->boolean('show_phone_numbers');
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
        Schema::dropIfExists('vf_dc_changes');
    }
}
