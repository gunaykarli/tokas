<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVfDslsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vf_dsls', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('contract_id');
            $table->string('AO_bundle_offering_code');
            $table->integer('group_change_group_id');
            $table->boolean('objection');
            $table->boolean('additional_contract');
            $table->integer('customer_number');
            $table->string('password');

            $table->integer('subscriber_id');
            $table->integer('tariff_id');
            $table->string('tariff_and _services');
            $table->string('owner_name');
            $table->string('owner_surname');
            $table->boolean('same_contact_address_owner');
            $table->boolean('DSL_available');
            $table->boolean('approval_DSL_downgrade');
            $table->smallInteger('NTBA_installation');
            $table->smallInteger('house_type');
            $table->smallInteger('apartment');
            $table->smallInteger('entrance');
            $table->smallInteger('floor');
            $table->string('location_TAE _box');
            $table->boolean('same_contact_address_for_installation');
            $table->boolean('same_contact_address_for_shipping');
            $table->string('salutation_for_shipping');
            $table->string('name_for_shipping');
            $table->string('surname_for_shipping');
            $table->string('company_name_for_shipping');

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
        Schema::dropIfExists('vf_dsls');
    }
}
