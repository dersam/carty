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
			$table->string('ip',46)->nullable(); //to allow for IPv6 addresses
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
			$table->integer('cart_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->timestamps();

			$table->primary(array('cart_id','product_id'));
			$table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cart_contents');
		Schema::dropIfExists('carts');
		Schema::dropIfExists('products');

	}

}
