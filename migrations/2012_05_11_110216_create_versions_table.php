<?php

class Version_Create_Versions_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('versions', function($table)
		{
			$table->increments('id');
			$table->integer('object_id')->index();
			$table->string('object_table', 255);
			$table->string('name', 255);
			$table->text('data');
			$table->string('hash', 255);
			$table->timestamps();
			$table->unique(array('object_id', 'object_table', 'hash'));
		});
	}


	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('versions');
	}

}