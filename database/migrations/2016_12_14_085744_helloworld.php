<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Helloworld extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('helloworld',function(Blueprint $table) {
			$table->increments('id');	
			$table->string('title',100);	
			$table->string('content');	
			//$table->json('json_str');	
			$table->boolean('boolfld');	
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
        //
		Schema::drop('helloworld');
    }
}
