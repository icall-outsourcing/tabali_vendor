<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->enum('active', ['Y','N'])->default('Y');
            $table->date('expire_at')->nullable();            
            $table->integer('created_by')->nullable()->comment('disable');
            $table->integer('updated_by')->nullable()->comment('disable');            
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
        Schema::drop('gifts');
    }
}
