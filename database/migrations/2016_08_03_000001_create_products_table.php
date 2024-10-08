<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->comment('disable');
            $table->string('sku');
            $table->string('description');
            $table->string('vendor');
            $table->string('buyer');
            $table->string('idept');
            $table->string('depname');
            $table->string('isdept');
            $table->string('subdepname');
            $table->string('iclas');
            $table->string('classname');
            $table->string('isclas');
            $table->string('subclassname');
            $table->string('tax');
            $table->string('price_b');
            $table->string('iupc');
            $table->string('ibyum');
            $table->string('buom');
            $table->string('sellinguom');
            $table->string('transferuom');
            $table->string('adescr');
            $table->string('StockStore1');
            $table->string('StockStore2');
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
        Schema::drop('products');
    }
}
