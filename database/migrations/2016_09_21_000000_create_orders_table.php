<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->comment('disable');
            $table->integer('version')->default(1);
            $table->integer('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->integer('account_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('branch_id')->unsigned()->index();
            $table->foreign('branch_id')->references('id')->on('branchs')->onDelete('cascade');
            $table->integer('driver_id')->unsigned()->index()->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->biginteger('phone_number');
            $table->biginteger('follow_up_phone');
            $table->enum('status', ['opened','viewed','processing','ondelivery','closed','canceled'])->default('opened');
            $table->decimal('total',9, 2);
            $table->enum('payment_method', ['Cash','Visa Card'])->default('Cash');
            $table->string('order_comment')->nullable();
            $table->string('branch_comment')->nullable();
            $table->timestamp('viewed_at')->nullable()->comment('disable');
            $table->timestamp('processing_at')->nullable()->comment('disable');
            $table->timestamp('ondelivery_at')->nullable()->comment('disable');
            $table->timestamp('delivered_at')->nullable()->comment('disable');
            $table->timestamp('closed_at')->nullable()->comment('disable');
            $table->timestamp('canceled_at')->nullable()->comment('disable');
            $table->integer('created_by')->nullable()->comment('disable');
            $table->integer('updated_by')->nullable()->comment('disable');
            $table->integer('deleted_by')->nullable()->comment('disable');
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
        Schema::drop('orders');
    }
}
