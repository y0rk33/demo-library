<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_id')->unique();
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('password', 60);
            $table->boolean('is_admin')->default(0);
            $table->rememberToken();

            // audit
            $table->string('created_by');
            $table->string('updated_by');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [
                'doc_id' => '000000000',
                'email' => 'admin@library.com',
                'first_name' => 'admin',
                'last_name' => 'admin',
                'date_of_birth' => '01/01/0001',
                'password' => \Illuminate\Support\Facades\Hash::make('Password1'),
                'is_admin' => '1',
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
        Schema::drop('users');
    }
}
