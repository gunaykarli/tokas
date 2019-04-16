<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('id');
            $table->smallInteger('customer_type');
            $table->string('salutation');
            $table->string('name');
            $table->string('surname');
            $table->date('birth_date');
            $table->smallInteger('identity_type');
            $table->string('identity_card_number');
            $table->string('company_name_1');
            $table->string('company_name_2');
            $table->string('company_registration_number');
            $table->string('district_court');

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
        Schema::dropIfExists('customers');
    }
}
