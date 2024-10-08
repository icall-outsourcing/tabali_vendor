<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('disable');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60)->comment('password');
            $table->rememberToken();
            $table->integer('created_by')->comment('disable');
            $table->integer('updated_by')->comment('disable');
            $table->integer('deleted_by')->comment('disable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
