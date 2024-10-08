<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logitems', function (Blueprint $table) {
            $table->increments('id')->comment('disable');
            $table->integer('order_item_id')->unsigned()->index();
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');

            $table->integer('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            
            $table->integer('weight');
            $table->integer('quantity');
            $table->decimal('uprice',9, 3);
            $table->decimal('tprice',9, 2);
            $table->enum('last_status', ['opened','updated','canceled'])->default('opened');
            $table->string('item_comment')->nullable();
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
        Schema::drop('logitems');
    }
}
