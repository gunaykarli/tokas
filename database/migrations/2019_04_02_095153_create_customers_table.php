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
            $table->smallInteger('customer_type');
            $table->string('salutation')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->date('birth_date')->nullable();
            $table->smallInteger('identity_type')->nullable();
            $table->string('identity_card_number')->nullable();
            $table->string('password')->nullable();

            $table->string('contact_person')->nullable();

            $table->string('company_name')->nullable();
            $table->string('company_registration_number')->nullable();
            $table->string('district_court')->nullable();

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
