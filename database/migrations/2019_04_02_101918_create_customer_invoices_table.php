<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('salutation');
            $table->string('name');
            $table->string('surname');
            $table->string('company_name_1');
            $table->string('company_name_2');
            $table->string('street');
            $table->smallInteger('house_number');
            $table->integer('PO_box');
            $table->string('country');
            $table->integer('postal_code');
            $table->string('city');
            $table->string('contact_person');
            $table->smallInteger('country_code');
            $table->smallInteger('area_code');
            $table->string('phone_number');
            $table->smallInteger('medium_type');
            $table->smallInteger('SMS_notification_NDC');
            $table->integer('SMS_notification_MSISDN');
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
        Schema::dropIfExists('customer_invoices');
    }
}
