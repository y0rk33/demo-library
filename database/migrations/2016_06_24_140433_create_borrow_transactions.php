<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrow_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('request_number');
            $table->integer('user_id')->unsigned();
            $table->integer('book_id')->unsigned();
            $table->date('borrowed_at');
            $table->date('returned_at');
            $table->date('to_be_returned_at');
            $table->string('status');

            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('borrow_transactions');
    }
}
