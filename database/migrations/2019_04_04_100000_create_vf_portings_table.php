<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVfPortingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vf_portings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id');
            $table->integer('phone_number_NDC');
            $table->integer('phone_number_MSISDN');
            $table->smallInteger('subsequent_porting_type');
            $table->date('entry_date');
            $table->string('previous_provider_name');
            $table->date('previous_provider_contract_end_date');
            $table->date('previous_provider_termination_date');
            $table->string('previous_provider_customer_name');
            $table->string('previous_provider_customer_surname');
            $table->date('previous_provider_customer_birth_date');
            $table->string('previous_provider_company_name');
            $table->smallInteger('desired_card_type');
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
            $table->boolean('porting_with_hardware');

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
        Schema::dropIfExists('vf_portings');
    }
}
