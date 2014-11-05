<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('users', function($table){
            $table->increments('id');
            $table->string('username',30);
            $table->string('password',60);
            $table->string('password_temp',60);
            $table->string('code',60);
            $table->string('firstName',30);
            $table->string('lastName',30);
            $table->string('email',30);
            $table->integer('access'); //
            $table->timestamps();
            $table->text('remember_token');

        });
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
