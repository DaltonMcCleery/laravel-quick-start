<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReusableBlocks extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();

		// REUSABLE BLOCKS
		Schema::dropIfExists('reusable_blocks');
		Schema::create('reusable_blocks', function (Blueprint $table) {
			$table->bigIncrements('id')->unsigned();
			$table->string('name');
			$table->text('content');
			$table->boolean('active')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::enableForeignKeyConstraints();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::disableForeignKeyConstraints();
		Schema::dropIfExists('reusable_blocks');
		Schema::enableForeignKeyConstraints();
	}
}