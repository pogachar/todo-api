<?php

class Schema extends CakeSchema {

	public $name = 'tasks';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $tasks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 255),
		'description' => array('type' => 'text', 'null' => true, 'default' => null),
		'author' => array('type' => 'string', 'null' => true, 'default' => null),
		'created_at' => array('type' => 'timestamp'),
		'completed_at' => array('type' => 'timestamp'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}