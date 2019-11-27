<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		if(!Schema::hasTable('permissions')){
			Schema::create('permissions', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('role_id');
				$table->string('action', 168);
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
		Schema::dropIfExists('permissions');
    }
}
