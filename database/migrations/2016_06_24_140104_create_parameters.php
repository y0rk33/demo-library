<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParameters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('description');
            $table->string('value');
            $table->timestamps();
        });

        DB::table('parameters')->insert(
            [
                'name' => 'ageLimit',
                'description' => 'The number of books can be borrowed by members less than 12 years old',
                'value' => '3',
            ]
        );

        DB::table('parameters')->insert([
                'name' => 'maxLoan',
                'description' => 'The max number of books can be borrowed by memeners more that 12 years old',
                'value' => '6',
            ]
        );
        DB::table('parameters')->insert([
                'name' => 'fine',
                'description' => 'The amount to be charged for overdue days of late return',
                'value' => '2',
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('borrow_limits');
    }
}
