<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVfCreditActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vf_credit_activations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id');
            $table->string('AO_bundle_offering_code');
            $table->integer('group_change_group_id');
            $table->boolean('objection');
            $table->boolean('additional_contract');
            $table->integer('customer_number');
            $table->string('password');
            $table->boolean('activation_with_hardware');
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
        Schema::dropIfExists('vf_credit_activations');
    }
}
