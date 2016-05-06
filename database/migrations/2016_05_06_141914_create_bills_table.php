<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration {
    public function up() {
        Schema::create('bills', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->unsigned()->unique();
            $table->timestamp('date');
            $table->string('description')->nullable();
            // REM: Customer foreign
            $table->integer('ref_id')->unsigned()->nullable();
            $table->foreign('ref_id')
                    ->references('id')->on('ref_type');
            $table->timestamp('manifest')->nullable();
            $table->integer('payment_id')->unsigned()->default(-1);
            $table->foreign('payment_id')
                    ->references('id')->on('payment_type');
            $table->float('amount');
            $table->float('int_amount');
            $table->float('driver_amount');
            $table->float('taxes');
            // REM: Driver foreign
            // Pickup & Delivery commission
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('bills');
    }
}
