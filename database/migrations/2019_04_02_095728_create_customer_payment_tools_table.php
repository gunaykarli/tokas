<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPaymentToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_payment_tools', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('card_number');
            $table->smallInteger('valid_to_month');
            $table->smallInteger('valid_to_year');
            $table->string('card_credit_institution');
            $table->string('IBAN');
            $table->string('BIC');
            $table->string('account_number');
            $table->string('bank_code');
            $table->string('bank_credit_institution');
            $table->string('account_owner');
            $table->string('usage');
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
        Schema::dropIfExists('customer_payment_tools');
    }
}
