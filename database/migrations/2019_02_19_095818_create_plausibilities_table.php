<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlausibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plausibilities', function (Blueprint $table) {
            $table->increments('id');

            $table->smallInteger('vodafone_tariff_id');
            $table->smallInteger('min_period_of_validity');
            $table->smallInteger('debit_authorization');
            $table->smallInteger('subsidy_authorization');
            $table->smallInteger('IMEI_acquisition');
            $table->smallInteger('telephone_book_entry');
            $table->smallInteger('fax_book_entry');
            $table->smallInteger('general_agreement');
            $table->smallInteger('VF_home_address');
            $table->smallInteger('ultra_card');
            $table->smallInteger('FN_porting');
            $table->smallInteger('AO_bundle');
            $table->smallInteger('member_type');
            $table->smallInteger('group_must');
            $table->smallInteger('tariff_type');

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
        Schema::dropIfExists('plausibilities');
    }
}
