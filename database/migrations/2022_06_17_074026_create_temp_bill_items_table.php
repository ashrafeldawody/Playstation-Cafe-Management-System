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
        Schema::create('temp_bill_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->integer('quantity');
            $table->float('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_bill_items');
    }
};
