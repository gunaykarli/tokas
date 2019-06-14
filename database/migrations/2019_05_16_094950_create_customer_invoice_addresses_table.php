<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvoiceAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoice_addresses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('customer_id');
            $table->string('salutation');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('company_name_1')->nullable();
            $table->string('street')->nullable();
            $table->smallInteger('house_number')->nullable();
            $table->integer('PO_box')->nullable();
            $table->string('country')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('contact_person')->nullable();
            $table->smallInteger('country_code')->nullable();
            $table->smallInteger('area_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->smallInteger('medium_type')->nullable();
            $table->smallInteger('SMS_notification_NDC')->nullable();
            $table->integer('SMS_notification_MSISDN')->nullable();

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
        Schema::dropIfExists('customer_invoice_addresses');
    }
}
