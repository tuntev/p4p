<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP4projectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('p4projects', function($table){
            $table->increments('id');
            $table->string('title',255);
            $table->string('student',255);
            $table->boolean('done');
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
        Schema::create('p4projects');
	}

}
