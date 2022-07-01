<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->nullable()->constrained();
            $table->foreignId('shift_id')->constrained()->onDelete('cascade');;
            $table->integer('time_limit')->nullable();
            $table->decimal('cafe_total',5,2)->default(0);
            $table->decimal('play_total',5,2)->default(0);
            $table->decimal('discount',5,2)->default(0);
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
        Schema::dropIfExists('bills');
    }
}
