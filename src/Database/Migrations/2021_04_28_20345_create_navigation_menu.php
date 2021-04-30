<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationMenu extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();

		// MENU
		Schema::dropIfExists('navigation_menu');
		Schema::create('navigation_menu', function (Blueprint $table) {
			$table->bigIncrements('id')->unsigned();
			$table->string('name');
			$table->integer('menu_order');
			$table->string('link')->nullable();
			$table->unsignedBigInteger('page_id')->nullable();
			$table->string('type');
			$table->unsignedBigInteger('parent_id')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::table('navigation_menu', function (Blueprint $table) {
			$table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
			$table->foreign('parent_id')->references('id')->on('navigation_menu')->onDelete('set null');
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
		Schema::dropIfExists('navigation_menu');
		Schema::enableForeignKeyConstraints();
	}
}