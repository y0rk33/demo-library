<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('isbn')->unique();
            $table->string('title');
            $table->string('edition');
            $table->date('year');
            $table->string('author');
            $table->string('description');
            $table->string('book_cover')->default('book_cover.jpg');
            $table->integer('current_qty');
            $table->integer('total_qty');
            $table->string('shelf_location');
            $table->softDeletes();

            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::drop('books');
    }
}
