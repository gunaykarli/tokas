<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractRelatedAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_related_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('related_id');
            $table->integer('contract_id');
            $table->string('street');
            $table->smallInteger('house_number');
            $table->string('city');
            $table->integer('postal_code');
            $table->string('country');

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
        Schema::dropIfExists('contract_related_addresses');
    }
}
