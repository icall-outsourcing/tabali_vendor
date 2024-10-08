<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('complaints', function (Blueprint $table) {

            $table->enum('Priority' , ['Normal','High'])->default('Normal');
            $table->enum('status'   , ['opened','processing','closed'])->default('opened');
            $table->enum('complaint_type'   , ['Item Availability','Product Condition','Website','Call Center','Policy & Procedures','Price','Promotions','Staff','Missing Items','Delivery','Store','Other'])->default('Other');
            $table->biginteger('follow_up_phone');
            $table->string('complain_comment')->nullable();
            $table->increments('id')->comment('disable');
            $table->integer('contact_id')->unsigned()->index();
            $table->integer('account_id')->unsigned()->index();
            $table->integer('branch_id')->unsigned()->index();
            $table->integer('driver_id')->unsigned()->index()->nullable();
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
        //
        Schema::drop('complaints');
    }
}
