<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerPromos extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();

		// BANNER PROMOS
		Schema::dropIfExists('banner_promos');
		Schema::create('banner_promos', function (Blueprint $table) {
			$table->bigIncrements('id')->unsigned();
			$table->string('name');
			$table->text('content')->nullable();
			$table->smallInteger('active')->default(1);
			$table->unsignedBigInteger('author_id')->nullable();
			$table->unsignedBigInteger('editor_id')->nullable();
			$table->timestamp('start_on')->nullable();
			$table->timestamp('end_on')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::table('banner_promos', function (Blueprint $table) {
			$table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
			$table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
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
		Schema::dropIfExists('banner_promos');
		Schema::enableForeignKeyConstraints();
	}
}