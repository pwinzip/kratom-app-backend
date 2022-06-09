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
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('farmers');
            $table->integer('remain_plant');
            $table->integer('addon_plant');
            $table->string('addon_species');
            $table->double('quantity_for_harvest'); //quantity_for_harvest
            $table->date('date_for_harvest'); //date_for_harvest
            // $table->double('quantity_for_sale'); //quantity_for_harvest
            // $table->date('date_for_sale'); //date_for_harvest
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
        Schema::dropIfExists('plants');
    }
};
