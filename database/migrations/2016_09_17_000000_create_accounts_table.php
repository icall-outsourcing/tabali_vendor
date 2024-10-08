<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id')->comment('disable');
            $table->string('account_name');
            $table->enum('account_type', ['Company','Home'])->default('Home');
            $table->biginteger('phone_number')->unique()->nullable();
            $table->string('governorate')->comment('lists');
            $table->string('district')->comment('lists');
            $table->string('area')->comment('lists');
            $table->string('address');
            $table->string('landmark')->nullable();
            $table->string('building_number')->nullable();
            $table->string('floor')->nullable();
            $table->string('apartment')->nullable();
            $table->integer('branch_id')->comment('relationship');
            $table->string('email')->nullable()->unique();
            $table->string('account_comment')->nullable();
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
        Schema::drop('accounts');
    }
}
