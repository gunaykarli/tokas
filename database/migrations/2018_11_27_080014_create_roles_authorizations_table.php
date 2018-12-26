<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesAuthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_authorizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('system_feature_id');
            $table->boolean('permission_of_role1');
            $table->boolean('permission_of_role2');
            $table->boolean('permission_of_role3');
            $table->boolean('permission_of_role4');
            $table->boolean('permission_of_role5');
            $table->boolean('permission_of_role6');
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
        Schema::dropIfExists('roles_authorizations');
    }
}
