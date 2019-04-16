<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_id');
            $table->string('street');
            $table->smallInteger('house_number');
            $table->string('city');
            $table->string('country');
            $table->integer('postal_code');
            $table->smallInteger('country_code');
            $table->smallInteger('area_code');
            $table->string('phone_number');
            $table->string('contact_person');
            $table->string('email');
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
        Schema::dropIfExists('customer_contacts');
    }
}
