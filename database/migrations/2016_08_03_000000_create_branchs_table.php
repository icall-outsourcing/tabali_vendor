<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branchs', function (Blueprint $table) {
            $table->increments('id')->comment('disable');
            $table->string('name');
            $table->text('branch_note')->nullable();
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
        Schema::drop('branchs');
    }
}
