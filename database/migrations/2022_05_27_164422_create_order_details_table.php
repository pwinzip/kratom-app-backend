<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            // $table->string('order_no');
            // $table->foreign('order_no')->references('order_no')
            //                             ->on('orders')
            //                             ->onDelete('cascade');
            $table->string('type'); // ใบ, ผง, สารสกัด
            $table->string('unit');
            $table->integer('buy_amount');
            $table->double('buy_price');
            $table->date('date_preferred');
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
        Schema::dropIfExists('order_details');
    }
};
