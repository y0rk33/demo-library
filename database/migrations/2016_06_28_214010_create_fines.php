<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->double('amount');
            $table->string('status')->default('Not Payed');

            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('borrow_transactions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fines');
    }
}
