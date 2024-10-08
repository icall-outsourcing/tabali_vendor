<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string("vouchercode");
            $table->string("gift_id");
            $table->enum('active', ['Y','N'])->default('Y');
            $table->enum('status', ['open','used','closed','canceled'])->default('open');
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
        Schema::drop('vouchers');
    }
}
