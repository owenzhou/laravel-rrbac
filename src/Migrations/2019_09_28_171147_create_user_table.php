<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		if(!Schema::hasTable('users')){
			/*Schema::create('admins', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name', 20);
				$table->string('password', 64)->nullable(false);
				$table->dateTime('created')->nullable(false);
			});*/
			Schema::create('users', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->string('email')->unique();
				$table->string('password');
				$table->rememberToken();
				$table->timestamps();
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
		Schema::dropIfExists('users');
    }
}
