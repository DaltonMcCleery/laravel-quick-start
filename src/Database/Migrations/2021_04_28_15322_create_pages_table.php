
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();

		// PAGES
		Schema::dropIfExists('pages');
		Schema::create('pages', function (Blueprint $table) {
			$table->bigIncrements('id')->unsigned();
			$table->string('name');
			$table->string('title');
			$table->string('slug')->nullable();
			$table->string('template')->default('page');
			$table->smallInteger('active')->default(1);
			$table->unsignedBigInteger('author_id')->nullable();
			$table->unsignedBigInteger('editor_id')->nullable();
			$table->string('meta_title');
			$table->text('meta_description');
			$table->text('meta_keywords')->nullable();
			$table->string('og_title')->nullable();
			$table->text('og_description')->nullable();
			$table->string('social_image')->nullable();
			$table->longtext('content')->nullable();
			$table->unsignedBigInteger('parent_id')->nullable();
			$table->date('page_date')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		// FOREIGN KEYS
		Schema::table('pages', function (Blueprint $table) {
			$table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
			$table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
			$table->foreign('parent_id')->references('id')->on('pages')->onDelete('set null');
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
		Schema::dropIfExists('pages');
		Schema::enableForeignKeyConstraints();
	}
}