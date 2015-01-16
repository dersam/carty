<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartyDb extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carts', function($table){
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->dateTime('began_shopping_at');
			$table->string('ip',46); //to allow for IPv6 addresses
			$table->timestamps();
		});

		Schema::create('products',function($table){
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('name',50);
			$table->text('description');
			$table->decimal('price_per_unit',10,2);
		});

		Schema::create('cart_contents',function($table){
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('cart_id')->unsigned();
			$table->integer('product_id')->unsigned();
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
		Schema::dropIfExists('carts');
		Schema::dropIfExists('products');
		Schema::dropIfExists('cart_contents');
	}

}
