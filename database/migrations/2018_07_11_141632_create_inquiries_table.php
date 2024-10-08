<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('inquiries', function (Blueprint $table) {
            $table->increments('id')->comment('disable');
            $table->integer('account_id')->unsigned()->index()->comment('hidden');
            $table->integer('contact_id')->unsigned()->index()->comment('hidden');
            $table->biginteger('follow_up_phone');
            $table->enum('status'   , ['opened','processing','closed'])->default('opened')->comment('disable');
            $table->enum('inquiry_type'   , ['Item Availability','Website','Policy & Procedures','Price','Branch Location','Working Hours','Inquiry Headoffice','Wrong Number','Call Disconnected','Delivery','Other'])->default('Other');
            $table->text('inquiry_comment')->nullable();
            $table->text('close_inquiry_comment')->nullable()->comment('disable');
            $table->integer('created_by')->nullable()->comment('disable');
            $table->integer('updated_by')->nullable()->comment('disable');
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
        Schema::drop('inquiries');
    }
}
