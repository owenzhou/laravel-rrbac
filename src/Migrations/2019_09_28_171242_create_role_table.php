<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		if(!Schema::hasTable('roles')){
			Schema::create('roles', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name', 20);
				$table->dateTime('created')->nullable(false);
			});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
		Schema::dropIfExists('roles');
    }
}
